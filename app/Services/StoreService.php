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
        $this->mediaService->path($this->path)->model($store);

        collect(['logo', 'team', 'cover'])
            ->each(fn($file) => $this->mediaService->save($request->file($file), properties: [
                'type' => $file,
                'type_id' => Media::IMAGE,
            ]));

        if ($request->has('qualities') and count($request->get('qualities'))) {
            $qualities = Quality::query()->whereIn('id', $request->get('qualities'))->get();
            $store->qualities()->sync($qualities);
            $store->load('qualities');
        }

        return $store->load('medias');
    }
}
