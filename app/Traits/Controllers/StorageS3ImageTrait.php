<?php

namespace App\Traits\Controllers;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait StorageS3ImageTrait
{
    private function storageImageInBucket(string $path, UploadedFile $file, Model $model, bool $featured = false): Model
    {
        $path = Storage::disk('s3')->putFile($path, $file, ['visibility' => 'public']);
        $model->medias()->create([
            'url' => Storage::disk('s3')->url($path),
            'path' => $path,
            'featured' => $featured,
        ]);
        if ($featured) {
            $model->load('featured_media');
        }

        return $model;
    }

    public function deleteImageFromBucket($imagePath): void
    {
        if (Storage::disk('s3')->exists($imagePath)) {
            Storage::disk('s3')->delete($imagePath);
            Media::query()->where('path', '=', $imagePath)->delete();
        }
    }
}
