<?php

namespace App\Http\Controllers;

use App\Exceptions\AtelierException;
use App\Http\Resources\ShoppingCartResource;
use App\Models\Device;
use App\Models\ShoppingCart;
use App\Models\User;
use App\Models\Variation;
use App\Services\OrderService;
use App\Services\PaypalService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShoppingCartController extends Controller
{
    public function __construct(
        private OrderService $orderService,
        private PaypalService $paypalService,
    ) {
    }

    public function index()
    {
        $variants = ShoppingCart::query()
            ->with('variation.product.medias', 'variation.medias')
            ->when(
                auth()->check(),
                fn($query) => $query->where('customer_type', User::class)->where('customer_id', auth()->id()),
                /** @throws AtelierException */
                fn($query) => $query->where('customer_type', Device::class)->where('customer_id', $this->getDeviceId()),
            )
            ->paginate(request('pageSize', 20));

        return ShoppingCartResource::collection($variants);
    }

    /**
     * @throws AtelierException
     */
    public function increase($variationId)
    {
        if (auth()->check()) {
            $customerType = User::class;
            $customerId = auth()->id();
        } else {
            $customerId = $this->getDeviceId();
            $customerType = Device::class;
            if (is_null($customerId)) {
                $customerId = Device::create(['uuid' => request()->header('x-device-uuid')])->value('id');
            }
        }

        $item = ShoppingCart::firstOrNew([
            'variation_id' => Variation::where('id', $variationId)->firstOrFail()->id,
            'customer_type' => $customerType,
            'customer_id' => $customerId,
        ]);
        $item->quantity = ($item->quantity ?? 0) + request('quantity', 1);
        $item->save();

        return $this->response([], 'Shopping cart updated.');
    }

    public function decrease(Request $request, int $variationId)
    {
        if (auth()->check()) {
            $customerType = User::class;
            $customerId = auth()->id();
        } else {
            $customerId = $this->getDeviceId();
            $customerType = Device::class;
        }

        /** @var ShoppingCart $item */
        $item = ShoppingCart::query()
            ->where('customer_type', $customerType)
            ->where('customer_id', $customerId)
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
        if (auth()->check()) {
            $customerType = User::class;
            $customerId = auth()->id();
        } else {
            $customerId = $this->getDeviceId();
            $customerType = Device::class;
            if (is_null($customerId)) {
                $customerId = Device::create(['uuid' => request()->header('x-device-uuid')])->value('id');
            }
        }

        ShoppingCart::query()
            ->where('customer_type', $customerType)
            ->where('customer_id', $customerId)
            ->where('variation_id', $variationId)
            ->delete();

        return $this->response([], 'Item removed from your cart.');
    }

    public function order()
    {
        $order = $this->orderService->createFromShoppingCart(auth()->id());

        return $this->paypalService->createOrder($order);
    }

    /**
     * @throws AtelierException
     */
    public function getDeviceId(): ?int
    {
        if (auth()->check()) {
            return null;
        }

        if (! request()->hasHeader('x-device-uuid')) {
            throw new AtelierException('There is no customer linked with the request.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return Device::select('id')->where('uuid', request()->header('x-device-uuid'))->value('id');
    }
}
