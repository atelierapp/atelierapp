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

        $storage = Storage::disk('s3')->putFile($this->path, $file, ['visibility' => 'public']);
        $attributes = array_merge($this->getParams($properties), [
            'url' => Storage::disk('s3')->url($storage),
            'path' => $storage,
        ]);

        return $this->model->medias()->create($attributes);
    }

    private function getParams(array $properties): array
    {
        $values = [];

        $toFields = ['type_id', 'featured', 'orientation'];
        foreach ($toFields as $toField) {
            if (isset($properties[$toField])) {
                $values[$toField] = $properties[$toField];
                unset($properties[$toField]);
            }
        }

        $values['extra'] = $properties;

        return $values;
    }

    public function saveImage(?UploadedFile $file, array $properties = []): ?Media
    {
        $properties['type_id'] = 1; // App\Models\MediaType::IMAGE

        return $this->save($file, $properties);
    }
}
