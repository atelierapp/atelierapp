<?php

namespace App\Services;

use App\Jobs\ProductViewCount;
use App\Models\Product;
use App\Models\Quality;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ProductService
{
    private string $path = 'products';

    public function __construct(
        private TagService $tagService,
        private CollectionService $collectionService,
        private MediaService $mediaService,
        private MaterialService $materialService,
        private VariationService $variationService
    ) {
        //
    }

    public function list(array $filters = [], $asPaginated = true): LengthAwarePaginator|Collection
    {
        $relations = ['style', 'medias', 'tags', 'store', 'categories'];
        if (request()->user('sanctum')) {
            $relations[] = 'authFavorite';
        }

        $query = Product::authUser()
            ->with($relations)
            ->whereHas('store', fn ($store) => $store->active())
            ->when($filters['inRandomOrder'] ?? false, fn($query) => $query->inRandomOrder())
            ->applyFiltersFrom($filters);

        return $asPaginated
            ? $query->paginate()
            : $query->get();
    }

    public function getBy(int $product, string $field = 'id'): Product
    {
        return Product::authUser()->where($field, '=', $product)->firstOrFail();
    }

    public function store(array $params): Product
    {
        $data = $params;
        $data['properties'] = [
            'dimensions' => [
                'depth' => (double) $params['depth'],
                'height' => (double) $params['height'],
                'width' => (double) $params['width'],
            ],
        ];

        $data = $this->processDiscountedAmount($data);
        $product = Product::create($data);
        $this->processQualities($product, Arr::get($params, 'qualities', []));
        $this->processImages($product, $data['images']);
        $this->variationService->duplicateFromProduct($product, $data['images']);
        $this->processCategories($product, [$data['category_id']]);
        $this->processTags($product, $data['tags']);
        $this->processMaterials($product, $data['materials']);
        $product->load('categories', 'medias', 'tags', 'materials');

        if (isset($data['collections'])) {
            $this->processCollections($product, $data['collections']);
            $product->load('collections');
        }

        if (isset($data['variations'])) {
            $this->processVariations($product, $data['variations']);
        }

        $product->load('variations.medias');

        return $product;
    }

    private function processDiscountedAmount($params)
    {
        $params['is_active'] = data_get($params, 'is_active', true);

        if (data_get($params, 'has_discount', false)) {
            if (data_get($params, 'is_discount_fixed', false)) {
                $params['discounted_amount'] = $params['discount_value'];
            } else {
                $percent = round($params['discount_value'] / 100, 2);
                $params['discounted_amount'] = round($params['price'] * $percent, 2);
            }
        } else {
            $params['discount_value'] = 0;
            $params['discounted_amount'] = 0;
        }

        return $params;
    }

    private function processQualities(Product &$product, array $qualities)
    {
        if (count($qualities)) {
            $qualities = Quality::query()->whereIn('id', $qualities)->get();
            $product->qualities()->sync($qualities);
            $product->load('qualities');
        }
    }

    public function processCategories(Product|int $product, array $categories): void
    {
        if (is_int($product)) {
            $product = $this->getBy($product);
        }

        $product->categories()->sync($categories);
    }

    /**
     * @param \App\Models\Product|int $product
     * @param array $images  [[orientation => front|side|perspective|plan, file => UploadedFile]]
     * @return void
     */
    public function processImages(Product|int $product, array $images): void
    {
        if (! empty($images)) {
            if (is_int($product)) {
                $product = $this->getBy($product);
            }

            $this->mediaService->path($this->path)->model($product);
            foreach ($images as $image) {
                $this->processImage($image);
            }
        }
    }

    /**
     * @param array $image  [orientation => front|side|perspective|plan, file => UploadedFile]
     * @return void
     */
    public function processImage(array $image): void
    {
        $this->mediaService->save($image['file'], [
            'orientation' => $image['orientation'],
            'featured' => $image['orientation'] == 'front',
            'type_id' => 1 // App\Models\MediaType::IMAGE
        ]);
    }

    public function processTags(Product|int $product, array $tags = []): void
    {
        if (! empty($tags)) {
            if (is_int($product)) {
                $product = $this->getBy($product);
            }

            $product->tags()->sync([]);
            $productTag = [];
            foreach ($tags as $tag) {
                $productTag[] = $this->tagService->getTag($tag['name']);
            }

            $product->tags()->saveMany($productTag);
        }
    }

    public function processMaterials(Product|int $product, array $materials)
    {
        if (! empty($materials)) {
            if (is_int($product)) {
                $product = $this->getBy($product);
            }

            $productMaterial = [];
            foreach ($materials as $material) {
                $productMaterial[] = $this->materialService->getMaterial($material['name'])->id;
            }

            $product->materials()->sync($productMaterial);
        }
    }

    public function processCollections(Product|int $product, array $collections): void
    {
        if (! empty($collections)) {
            if (is_int($product)) {
                $product = $this->getBy($product);
            }

            $product->collections()->sync([]);

            $productCollection = [];
            foreach ($collections as $collection) {
                $productCollection[] = $this->collectionService->getCollectionToAuth($collection['name']);
            }

            $product->collections()->saveMany($productCollection);
        }
    }

    private function processVariations(Product|int $product, array $variations)
    {
        if (! empty($variations)) {
            if (is_int($product)) {
                $product = $this->getBy($product);
            }

            $this->variationService->createManyToProduct($product, $variations);
        }
    }

    public function update(Product|int $product, array $params): Product
    {
        // TODO :: validate logic process when receive is_unique param and have stock more than 1
        if (is_int($product)) {
            $product = $this->getBy($product);
        }

        $params['properties'] = [];
        if (isset($params['depth'])) {
            $params['properties']['dimensions']['depth'] = (double) $params['depth'];
        }
        if (isset($params['height'])) {
            $params['properties']['dimensions']['height'] = (double) $params['height'];
        }
        if (isset($params['width'])) {
            $params['properties']['dimensions']['width'] = (double) $params['width'];
        }

        $params = $this->processDiscountedAmount($params);
        $product->fill($params);
        $product->save();

        $this->processQualities($product, Arr::get($params, 'qualities'));
        $this->processCategories($product, [$params['category_id']]);
        $this->processTags($product, $params['tags']);
        $this->processMaterials($product, $params['materials']);
        $product->load('categories', 'medias', 'tags', 'materials');

        if (isset($params['collections'])) {
            $this->processCollections($product, $params['collections']);
            $product->load('collections');
        }

        return $product;
    }

    public function image(Product|int $product, array $request): Product
    {
        if (is_int($product)) {
            $product = $this->getBy($product);
        }

        $this->processImages($product, $request['images']);
        $this->loadRelations($product);

        return $product;
    }

    public function loadRelations(Product &$product)
    {
        $product->load('categories', 'style', 'store', 'materials', 'medias', 'tags', 'featured_media', 'collections');

        if (auth()->check()) {
            $product->load('authFavorite');
        }
    }

    public function processViewCount(Product $product)
    {
        config(['queue.default' => 'sync']); // TODO: temporary added sync queue to add product views to fix database queues, or another
        ProductViewCount::dispatch($product, auth()->id());
    }

}
