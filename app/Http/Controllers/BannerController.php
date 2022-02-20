<?php

namespace App\Http\Controllers;

use App\Http\Requests\BannerStoreRequest;
use App\Http\Requests\BannerUpdateRequest;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use App\Traits\Controllers\StorageS3ImageTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BannerController extends Controller
{
    use StorageS3ImageTrait;

    public function index(): AnonymousResourceCollection
    {
        $banners = Banner::paginate();

        return BannerResource::collection($banners);
    }

    public function store(BannerStoreRequest $request): BannerResource
    {
        $banner = Banner::create($request->validated());
        $banner = $this->storageImageInBucket('banners', $request->file('image'), $banner, true);

        return BannerResource::make($banner);
    }

    public function show(Banner $banner): BannerResource
    {
        return BannerResource::make($banner);
    }

    public function update(BannerUpdateRequest $request, Banner $banner): BannerResource
    {
        $banner->update($request->validated());

        return BannerResource::make($banner);
    }

    public function image(ImageRequest $request, Banner $banner): BannerResource
    {
        $this->deleteImageFromBucket($banner->featured_media->path);
        $banner = $this->storageImageInBucket('banners', $request->file('image'), $banner, true);

        return BannerResource::make($banner);
    }

    public function destroy(Banner $banner): JsonResponse
    {
        $banner->delete();

        return $this->responseNoContent();
    }
}
