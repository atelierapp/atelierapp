<?php

namespace App\Services;

use App\Exceptions\AtelierException;
use App\Models\Media;
use App\Models\Quality;
use App\Models\Role;
use App\Models\Store;
use Bouncer;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Cashier\Cashier;

class StoreService
{
    private string $path = 'stores';

    public function __construct(
        private MediaService $mediaService,
        private RoleService $roleService
    ) {
        //
    }

    public function store(FormRequest $request): Store
    {
        $seller = auth()->user();
        $data = $request->only(['name', 'story']);
        $data['user_id'] = $seller->id;
        $store = Store::create($data);
        $seller->createOrGetStripeCustomer();
        Bouncer::assign(Role::SELLER)->to($seller);
        $this->processQualities($store, $request);
        $this->processImages($store, $request);

        return $store;
    }

    public function getById(int $id): Store
    {
        if (Bouncer::is(auth()->user())->a(Role::SELLER)) {
            return Store::authUser()->where('id', '=', $id)->firstOrFail();
        }

        return Store::where('id', '=', $id)->firstOrFail();
    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    public function getMySellerStore(): Store
    {
        if (!$this->roleService->isSeller()) {
            throw new AtelierException(__('authorization.without_access'), 403);
        }

        return Store::where('user_id', '=', auth()->id())
            ->with('qualities')
            ->firstOrFail();
    }

    public function update(FormRequest $request, $store): Store
    {
        $store = $this->getById($store);
        $store->update($request->only(['name', 'story']));
        $this->processQualities($store, $request);
        $this->processImages($store, $request);

        return $store;
    }

    public function image(FormRequest $request, $store): Store
    {
        $store = $this->getById($store);
        $this->processImages($store, $request);

        return $store;
    }

    private function processQualities(Store &$store, FormRequest $request)
    {
        if ($request->has('qualities') and count($request->get('qualities'))) {
            $qualities = Quality::query()->whereIn('id', $request->get('qualities'))->get();
            $store->qualities()->sync($qualities);
            $store->load('qualities');
        }
    }

    private function processImages(Store &$store, FormRequest $request)
    {
        $this->mediaService->path($this->path)->model($store);
        $images = ['logo', 'team', 'cover'];

        if ($request->hasAny($images)) {
            collect($images)->each(function ($file) use ($store, $request) {
                if ($request->has($file)) {
                    $currentMedia =  $store->medias()->where('orientation', $file)->first();
                    if (!is_null($currentMedia)) {
                        // TODO :: improvement process to get media
                        $this->mediaService->delete($currentMedia->path);
                    }
                    $this->mediaService->save($request->file($file), [
                        'orientation' => $file,
                        'type_id' => Media::IMAGE,
                    ]);
                }
            });

            $store->load('medias');
        }
     }

    public function impactStore(string|int|Store $store, array $params)
    {
        if (!$store instanceof Store) {
            $store = $this->getById($store);
        }

        $syncQualities = [];
        foreach ($params['qualities'] as $quality) {
            $syncQualities[$quality] = ['is_impact' => true];
        }
        $store->qualities()->sync($syncQualities);
    }
}
