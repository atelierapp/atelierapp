<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponDetail;
use App\Models\CouponUse;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

class CouponService
{
    public function create(int|string $storeId, array $values): Coupon
    {
        $coupon = Coupon::create(array_merge($values, ['store_id' => $storeId]));
        if ($values['mode'] == Coupon::MODE_PRODUCT) {
            $this->setProductsAsDetails($coupon, $values['products']);
        }

        return $coupon;
    }

    public function getBy(int|string $coupon, string $field = 'id'): Coupon
    {
        return Coupon::authUser()->where($field, '=', $coupon)->firstOrFail();
    }

    public function update(int|string $coupon, array $values): Coupon
    {
        $coupon = $this->getBy($coupon);
        $coupon->fill($values);
        $coupon->save();
        if ($values['mode'] == Coupon::MODE_PRODUCT) {
            $this->setProductsAsDetails($coupon, $values['products']);
        }

        return $coupon;
    }

    public function setProductsAsDetails(Coupon $coupon, array $productIds): void
    {
        CouponDetail::where('coupon_id', $coupon->id)->delete();
        Product::authUser()
            ->whereIn('id', $productIds)
            ->get()
            ->each(fn ($product) => CouponDetail::create([
                'coupon_id' => $coupon->id,
                'model_type' => Product::class,
                'model_id' => $product->id,
            ]));
    }

    public function getProductsFromCouponId($couponId)
    {
        $coupon = $this->getBy($couponId)->load('details', 'details.counponable');

        return $coupon->details;
    }

    public function applyCouponFromCode(?string $coupon, Order $parentOrder): void
    {
        if (empty($coupon)) {
            return;
        }

        $coupon = Coupon::authUser()->where('code', '=', $coupon)->firstOrNew();

        if ($this->validateIfCanApply($coupon)) {
            $couponUsed = false;

            // i believe that is better implement by pipeline pattern
            if ($coupon->mode == Coupon::MODE_TOTAL) {
                $parentOrder->loadMissing('details', 'subOrders.details');
                $parentOrder = $this->applyToOrder($parentOrder, $coupon);
                $parentOrder->details->each(fn ($detail) => $this->applyToOrderDetail($detail, $coupon));
                $parentOrder->subOrders->each(fn ($subOrder) => $this->applyToOrder($subOrder, $coupon));
                $parentOrder->subOrders->pluck('details')->collapse()->each(fn ($detail) => $this->applyToOrderDetail($detail, $coupon));
                $couponUsed = true;
            }

            if ($coupon->mode == Coupon::MODE_SELLER) {
                $parentOrder->loadMissing('details', 'subOrders.details');
                $parentOrder->subOrders->where('store_id', $coupon->store_id)->each(function ($subOrder) use ($coupon) {
                    $this->applyToOrder($subOrder, $coupon);
                    $subOrder->details->each(fn ($detail) => $this->applyToOrderDetail($detail, $coupon));
                });
                $parentOrder->load('subOrders');

                $parentOrder->total_price = $parentOrder->subOrders->sum->total_price;
                $parentOrder->total_revenue = $parentOrder->subOrders->sum->total_revenue;
                $parentOrder->discount_amount = $parentOrder->subOrders->sum->discount_amount;
                $parentOrder->final_price = $parentOrder->subOrders->sum->final_price;
                $parentOrder->items = $parentOrder->subOrders->sum->items;
                $parentOrder->save();
                $couponUsed = true;
            }

            if ($coupon->mode == Coupon::MODE_PRODUCT) {
                $coupon->loadMissing('appliedProducts');
                $parentOrder->loadMissing('subOrders');
                $orders = $parentOrder->subOrders->pluck('id');
                $orders[] = $parentOrder->id;
                $details = OrderDetail::query()
                    ->whereIn('product_id', $coupon->appliedProducts->pluck('model_id'))
                    ->whereIn('order_id', $orders)
                    ->get();
                if ($details->count()) {
                    $details->each(fn ($detail) => $this->applyToOrderDetail($detail, $coupon));
                    Order::whereIn('id', $orders)
                        ->with('details')
                        ->get()
                        ->each(function ($order) {
                            $order->total_revenue = $order->details->sum->total_revenue;
                            $order->discount_amount = $order->details->sum->discount_amount;
                            $order->final_price = $order->details->sum->final_price;
                            $order->save();
                        });
                    $couponUsed = true;
                }
            }

            if ($couponUsed) {
                $this->storeUse($coupon->id, $parentOrder->user_id);
                $this->incrementUse($coupon);
            }
        }
    }

    // Validations
    public function validateIfCanApply(Coupon $coupon): bool
    {
        if ($coupon->exists()) {
            return $coupon->is_active
                && $this->validateIfCanApplyByCouponUses($coupon)
                && $this->validateIfCanApplyByValidityDates($coupon);
        }

        return false;
    }

    public function validateIfCanApplyByCouponUses(Coupon $coupon): bool
    {
        return $coupon->max_uses > (int) $coupon->current_uses;
    }

    public function validateIfCanApplyByValidityDates(Coupon $coupon): bool
    {
        if (! is_null($coupon->start_date) && ! is_null($coupon->end_date)) {
            return now()->betweenIncluded($coupon->start_date, $coupon->end_date->endOfDay());
        }

        if (! is_null($coupon->start_date)) {
            return now()->greaterThanOrEqualTo($coupon->start_date);
        }

        if (! is_null($coupon->end_date)) {
            return now()->lessThanOrEqualTo($coupon->end_date);
        }

        return true;
    }

    // Manage coupon
    public function storeUse($couponId, $customerId): CouponUse
    {
        return CouponUse::create([
            'coupon_id' => $couponId,
            'user_id' => $customerId,
        ]);
    }

    public function incrementUse(int|Coupon $coupon): void
    {
        $coupon = $coupon instanceof Coupon ? $coupon : $this->getBy($coupon);
        $coupon->increment('current_uses');
        $coupon->save();
    }

    private function applyToOrder(Order $order, Coupon $coupon): Order
    {
        $order->discount_amount = $this->getAmountOfDiscount($coupon, $order->total_price);
        $order->final_price = $order->total_price - $order->discount_amount;
        $order->save();

        return $order;
    }

    private function applyToOrderDetail(OrderDetail $detail, Coupon $coupon): OrderDetail
    {
        $detail->discount_amount = $this->getAmountOfDiscount($coupon, $detail->total_price);
        $detail->final_price = $detail->total_price - $detail->discount_amount;
        $detail->save();

        return $detail;
    }

    public function getAmountOfDiscount(Coupon $coupon, $amountToApply): float|int
    {
        if ($coupon->is_fixed) {
            return $coupon->amount * 100;
        }

        return round($amountToApply * ($coupon->amount / 100), 2);
    }

    public function delete($coupon): void
    {
        $coupon = $this->getBy($coupon);
        if ($coupon->mode == Coupon::MODE_PRODUCT) {
            CouponDetail::where('coupon_id', $coupon->id)->delete();
        }
        $coupon->delete();
    }

    // public function getFinalPrice($unitPrice, $quantity, $couponId): float
    // {
    //     return round(($unitPrice * $quantity) - $this->getAmountOfDiscount($couponId, $unitPrice, $quantity), 2);
    // }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    // public function validateIfCanApplyByTotalPrice(Coupon $coupon, $amountToValidate)
    // {
    //     return ! ($coupon->is_fixed && $coupon->amount > $amountToValidate);
    // }

    // public function validateIfCanApplyWhenIsDiscountPerProduct(Coupon $coupon, $productsToValidate)
    // {
    //     if (count($productsToValidate) > 0 && $coupon->mode == Coupon::MODE_PRODUCT) {
    //         $couponProducts = $this->getProductsFromCouponId($coupon->id)->pluck('model.id');
    //         $result = $productsToValidate->whereIn('id', $couponProducts);
    //
    //         if ($cant = count($result)) {
    //             $text = $cant == 1 ? 'El producto ' : 'Los productos ';
    //             $text .= implode(', ', $result->pluck('name')->toArray());
    //             $text .= ', ya dispone';
    //             $text .= $cant == 1 ? '' : 'n';
    //             $text .= ' de un descuento promocional, no es posible aplicar su cupón';
    //             throw new AtelierException($text, Response::HTTP_CONFLICT);
    //         }
    //     }
    // }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    // public function validateIfCanApplyWhenIsDiscountPerTotal(Coupon $coupon, $productsToValidate)
    // {
    //     if (count($productsToValidate) > 0 && $coupon->mode == Coupon::MODE_TOTAL) {
    //         $text = 'No es posible agregar el cupón, tu carrito ya tiene productos con descuentos promocionales';
    //
    //         throw new AtelierException($text, Response::HTTP_CONFLICT);
    //     }
    // }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    // public function validateIfCanApplyByUses(Coupon $coupon, $customerId)
    // {
    //     if (! empty($customerId)) {
    //         $params = [
    //             'customer_id' => $customerId,
    //             'coupon_id' => $coupon,
    //         ];
    //
    //         // $useOrders = app(OrderContractService::class)->getByParams($params); // TODO : validar esta parte
    //
    //         if (count($useOrders)) {
    //             throw new AtelierException('Sólo puede usar el cupón 1 vez', Response::HTTP_CONFLICT);
    //         }
    //     }
    // }

    // public function decrementUse(int|Coupon $coupon): void
    // {
    //     $coupon = $coupon instanceof Coupon ? $coupon : $this->getBy($coupon);
    //     $coupon->decrement('current_uses');
    // }
}