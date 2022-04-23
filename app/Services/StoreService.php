<?php

namespace App\Services;

use App\Models\Media;
use App\Models\Quality;
use App\Models\Store;
use Illuminate\Foundation\Http\FormRequest;

class StoreService
{
    private string $path = 'stores';

    public function __construct(private MediaService $mediaService)
    {
        //
    }

    public function store(FormRequest $request): Store
    {
        $store = Store::create($request->only(['name', 'story']));
        $this->processQualities($store, $request);
        $this->processImages($store, $request);

        return $store;
    }

    public function getById(int $id): Store
    {
        return Store::where('id', '=', $id)->firstOrFail();
    }

    public function update(FormRequest $request, $store)
    {
        $store = $this->getById($store);
        $store->update($request->only(['name', 'story']));
        $this->processQualities($store, $request);
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
                $currentMedia =  $store->medias()->where('extra>type', $file)->first();
                if (!is_null($currentMedia)) {
                    // TODO :: improvement process to get media
                    $this->mediaService->delete($currentMedia->path);
                }
                $this->mediaService->save($request->file($file), [
                    'type' => $file,
                    'type_id' => Media::IMAGE,
                ]);
            });

            $store->load('medias');
        }
     }
}
