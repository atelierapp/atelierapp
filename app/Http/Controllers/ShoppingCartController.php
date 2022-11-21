<?php

namespace App\Http\Controllers;

use App\Exceptions\AtelierException;
use App\Http\Requests\ReplaceShoppingCartRequest;
use App\Http\Resources\ShoppingCartResource;
use App\Models\Device;
use App\Models\ShoppingCart;
use App\Models\User;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ShoppingCartController extends Controller
{
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
            ->paginate(request('pageSize', 1000));

        return ShoppingCartResource::collection($variants);
    }

    /**
     * @throws AtelierException
     */
    public function increase($variationId)
    {
        [$customerType, $customerId] = $this->getCustomerTypeAndId();

        $item = ShoppingCart::firstOrNew([
            'variation_id' => Variation::where('id', $variationId)->firstOrFail()->id,
            'customer_type' => $customerType,
            'customer_id' => $customerId,
        ]);
        $item->quantity = ($item->quantity ?? 0) + request('quantity', 1);
        $item->save();

        return $this->response([], 'Shopping cart updated.');
    }

    /**
     * @throws AtelierException
     */
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

    /**
     * @throws AtelierException
     */
    public function remove(Request $request, int $variationId)
    {
        [$customerType, $customerId] = $this->getCustomerTypeAndId();

        ShoppingCart::query()
            ->where('customer_type', $customerType)
            ->where('customer_id', $customerId)
            ->where('variation_id', $variationId)
            ->delete();

        return $this->response([], 'Item removed from your cart.');
    }

    /**
     * @throws AtelierException
     */
    public function replace(ReplaceShoppingCartRequest $request)
    {
        [$customerType, $customerId] = $this->getCustomerTypeAndId();

        ShoppingCart::query()
            ->where('customer_type', $customerType)
            ->where('customer_id', $customerId)
            ->delete();

        $variantsWithQuantities = $request->validated();

        foreach ($variantsWithQuantities as $variant) {
            ShoppingCart::create([
                'customer_type' => $customerType,
                'customer_id' => $customerId,
                'variation_id' => $variant['variation_id'],
                'quantity' => (int)$variant['quantity'],
            ]);
        }

        return $this->response([], __('shopping-cart.the-shopping-cart-has-been-updated'));
    }

    public function transferFromDeviceToUser(Request $request)
    {
        $userId = auth()->id();

        // First, let's clear any previous user shopping cart
        ShoppingCart::query()
            ->where('customer_type', User::class)
            ->where('customer_id', $userId)
            ->delete();

        // Then, let's identify the device
        $deviceId = Device::where('uuid', $request->get('uuid'))->value('id');

        // Finally, let's transfer the device's shopping-cart to the user
        ShoppingCart::query()
            ->where('customer_type', Device::class)
            ->where('customer_id', $deviceId)
            ->update([
                'customer_type' => User::class,
                'customer_id' => $userId,
            ]);

        return $this->response([], __('shopping-cart.shopping-cart-transferred-to-user'));
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

    /**
     * @return array
     * @throws AtelierException
     */
    private function getCustomerTypeAndId(): array
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

        return array($customerType, $customerId);
    }
}
