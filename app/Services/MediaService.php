<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    private string $path;
    private Model $model;

    public function delete($imagePath): void
    {
        if (!is_null($imagePath)) {
            Storage::disk('s3')->delete($imagePath);
            Media::query()->where('path', '=', $imagePath)->delete();
        }
    }

    public function path(string $path): MediaService
    {
        $this->path = $path;

        return $this;
    }

    public function model(Model $model): MediaService
    {
        $this->model = $model;

        return $this;
    }

    public function save(?UploadedFile $file, array $properties = []): ?Media
    {
        if (is_null($file)) {
            return null;
        }

        $file = $this->uploadImage($file);

        return $this->attachToModel($file, $properties);
    }

    public function saveImage(?UploadedFile $file, array $properties = []): ?Media
    {
        $properties['type_id'] = 1; // \App\Models\MediaType::IMAGE

        return $this->save($file, $properties);
    }

    public function saveImageFromUrl(?string $imageUrl, array $properties = []): ?Media
    {
        $properties['type_id'] = MediaType::IMAGE;

        if (str_contains($imageUrl, 'https://atelier-production-bucket.s3.amazonaws.com') ||
            str_contains($imageUrl, 'https://atelier-staging-bucket.s3.amazonaws.com')
        ) {
            $path = str_replace([
                'https://atelier-production-bucket.s3.amazonaws.com/',
                'https://atelier-staging-bucket.s3.amazonaws.com/'
            ], '', $imageUrl);

            $attributes = array_merge($this->getParams($properties), [
                'url' => $imageUrl,
                'path' => $path,
            ]);
        }
        
        return $this->model->medias()->create($attributes);
    }

    private function uploadImage(mixed $file): bool|string
    {
        return Storage::disk('s3')->putFile($this->path, $file, ['visibility' => 'public']);
    }

    private function attachToModel($storage, array $properties = [])
    {
        $attributes = array_merge($this->getParams($properties), [
            'url' => Storage::disk('s3')->url($storage),
            'path' => $storage,
        ]);

        return $this->model->medias()->create($attributes);
    }

    private function getParams(array $properties): array
    {
        $values = [];

        $toFields = ['type_id', 'featured', 'orientation', 'extra'];
        foreach ($toFields as $toField) {
            if (isset($properties[$toField])) {
                $values[$toField] = $properties[$toField];
                unset($properties[$toField]);
            }
        }

        foreach (['id', 'mediable_type', 'mediable_id', 'url', 'path', 'created_at', 'updated_at'] as $attribute) {
            unset($properties[$attribute]);
        }
        if (count($properties)) {
            $values['extra'] = array_merge($values['extra'], $properties);
        }

        return $values;
    }

    public function duplicate(Media $media)
    {
        $copyPath = str_replace('.', "_{$this->model->id}_forked.", $media->path);
        Storage::disk('s3')->copy($media->path, $copyPath);
        $this->attachToModel($copyPath, $media->toArray());
    }
}
