<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShoppingCartResource;
use App\Models\ShoppingCart;
use App\Models\Variation;
use App\Services\OrderService;
use App\Services\PaypalService;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private PaypalService $paypalService
    ) {
    }

    public function index()
    {
        $variants = ShoppingCart::query()
            ->with('variation.product.medias', 'variation.medias')
            ->where('user_id', auth()->id())
            ->paginate(request('pageSize', 20));

        return ShoppingCartResource::collection($variants);
    }

    public function increase($variationId)
    {
        $item = ShoppingCart::firstOrNew([
            'variation_id' => Variation::where('id', $variationId)->firstOrFail()->id,
            'user_id' => auth()->id(),
        ]);
        $item->quantity = ($item->quantity ?? 0) + request('quantity', 1);
        $item->save();

        return $this->response([], 'Shopping cart updated.');
    }

    public function decrease(Request $request, int $variationId)
    {
        /** @var ShoppingCart $item */
        $item = ShoppingCart::where('user_id', auth()->id())
            ->where('variation_id', $variationId)
            ->first();

        if (is_null($item)) {
            return $this->response([], 'Item already removed from cart.');
        }
        if ($item->quantity === 1) {
            $item->delete();
        } else {
            $item->quantity = $item->quantity - 1;
            $item->save();
        }

        return $this->response([], 'Item quantity reduced.');
    }

    public function remove(Request $request, int $variationId)
    {
        ShoppingCart::where('user_id', auth()->id())
            ->where('variation_id', $variationId)
            ->delete();

        return $this->response([], 'Item removed from your cart.');
    }

    public function order()
    {
        $order = $this->orderService->createFromShoppingCart(auth()->id());

        return $this->paypalService->createOrder($order);
    }
}
