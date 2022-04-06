<?php

namespace App\Services;

use App\Models\Media;
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

        return $store->load('medias');
    }
}
