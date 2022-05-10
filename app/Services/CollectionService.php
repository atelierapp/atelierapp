<?php

namespace App\Services;

use App\Models\Collection as CollectionModel;
use Illuminate\Http\UploadedFile;

class CollectionService
{
    public function __construct(private MediaService $mediaService)
    {
        //
    }

    public function getCollectionToAuth(string $collectionName): CollectionModel
    {
        return CollectionModel::updateOrCreate(['name' => $collectionName, 'user_id' => auth()->id()]);
    }

    public function processImage(CollectionModel|int $collection, UploadedFile $file): CollectionModel
    {
        if (is_int($collection)) {
            $collection = CollectionModel::authUser()->whereId($collection)->firstOrFail();
        }

        $collection->load('featured_media');
        $this->mediaService->delete($collection->featured_media->path);
        $this->mediaService->model($collection)->path('collections');
        $this->mediaService->saveImage($file, ['featured' => true]);
        $collection->load('featured_media');

        return $collection;
    }
}
