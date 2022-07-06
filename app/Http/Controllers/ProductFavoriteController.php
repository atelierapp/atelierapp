<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Services\FavoriteService;

class ProductFavoriteController extends Controller
{
    public function __construct(private FavoriteService $favoriteService)
    {
        $this->middleware('auth:sanctum');
    }

    public function __invoke($product)
    {
        $result = $this->favoriteService->manageToProduct($product);

        if ($result) {
            $text = 'added to';
            $code = 201;
        } else {
            $text = 'removed from';
            $code = 204;
        }

        return response()->json(['message' => "Product was {$text} favorites list."], $code);
    }
}
