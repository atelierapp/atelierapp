<?php

namespace App\Services;

use App\Models\Collection;
use Illuminate\Http\UploadedFile;

class CollectionService
{
    public function __construct(private MediaService $mediaService)
    {
        //
    }

    public function store(array $params): Collection
    {
        $params['user_id'] = auth()->id();

        return Collection::create($params);
    }

    public function getById(int $collectionId, bool $throwable = false): Collection
    {
        $query = Collection::authUser()->where('id', $collectionId);

        return $throwable
            ? $query->firstOrFail()
            : $query->firstOrNew();
    }

    public function update(Collection|int $collection, array $params): Collection
    {
        $collection = $this->getById($collection);
        $collection->update($params);

        return $collection;
    }

    public function getCollectionToAuth(string $collectionName): Collection
    {
        return Collection::updateOrCreate(['name' => $collectionName, 'user_id' => auth()->id()]);
    }

    public function processImage(Collection|int $collection, UploadedFile $file): Collection
    {
        if (is_int($collection)) {
            $collection = Collection::authUser()->whereId($collection)->firstOrFail();
        }

        $collection->load('featured_media');
        $this->mediaService->delete($collection->featured_media->path);
        $this->mediaService->model($collection)->path('collections');
        $this->mediaService->saveImage($file, ['featured' => true]);
        $collection->load('featured_media');

        return $collection;
    }
}
