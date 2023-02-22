<?php

namespace App\Services;

use App\Exceptions\AtelierException;
use App\Models\Coupon;
use App\Models\CouponUse;
use Illuminate\Http\Response;

class CouponService
{

    public function getBy(int|string $coupon, string $field = 'id'): Coupon
    {
        return Coupon::where($field, '=', $coupon)->firstOrFail();
    }

    public function getFinalPrice($unitPrice, $quantity, $couponId): float
    {
        return round(($unitPrice * $quantity) - $this->getAmountOfDiscount($couponId, $unitPrice, $quantity), 2);
    }

    public function getProductsFromCouponId($couponId)
    {
        $coupon = $this->getBy($couponId)->load('details', 'details.counponable');

        return $coupon->details;
    }

    /**
     * @param $couponId
     * @param $unitPrice
     * @param $quantity [when is zero 0, to evaluate is the $unitPrice param]
     */
    public function getAmountOfDiscount($couponId, $unitPrice, $quantity = 1)
    {
        $coupon = $this->getBy($couponId);
        $totalPrice = $unitPrice * $quantity;

        if ($coupon->is_fixed) {
            return $coupon->amount * $quantity;
        }

        return round($totalPrice * ($coupon->amount / 100), 2);
    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    public function validateIfCanApplyByTotalPrice(Coupon $coupon, $amountToValidate)
    {
        if ($coupon->is_fixed && $coupon->amount > $amountToValidate) {
            throw new AtelierException('El descuento del cupón sobrepasa al monto de su orden', Response::HTTP_CONFLICT);
        }
    }

    public function validateIfCanApplyWhenIsDiscountPerProduct(Coupon $coupon, $productsToValidate)
    {
        if (count($productsToValidate) > 0 && $coupon->mode == Coupon::PRODUCT) {
            $couponProducts = $this->getProductsFromCouponId($coupon->id)->pluck('model.id');
            $result = $productsToValidate->whereIn('id', $couponProducts);

            if ($cant = count($result)) {
                $text = $cant == 1 ? 'El producto ' : 'Los productos ';
                $text .= implode(', ', $result->pluck('name')->toArray());
                $text .= ', ya dispone';
                $text .= $cant == 1 ? '' : 'n';
                $text .= ' de un descuento promocional, no es posible aplicar su cupón';
                throw new AtelierException($text, Response::HTTP_CONFLICT);
            }
        }
    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    public function validateIfCanApplyWhenIsDiscountPerTotal(Coupon $coupon, $productsToValidate)
    {
        if (count($productsToValidate) > 0 && $coupon->mode == Coupon::TOTAL) {
            $text = 'No es posible agregar el cupón, tu carrito ya tiene productos con descuentos promocionales';

            throw new AtelierException($text, Response::HTTP_CONFLICT);
        }
    }

    /**
     * @throws \App\Exceptions\AtelierException
     */
    public function validateIfCanApplyByUses(Coupon $coupon, $customerId)
    {
        if (!empty($customerId)) {
            $params = [
                'customer_id' => $customerId,
                'coupon_id' => $coupon,
            ];

            // $useOrders = app(OrderContractService::class)->getByParams($params); // TODO : validar esta parte

            if (count($useOrders)) {
                throw new AtelierException('Sólo puede usar el cupón 1 vez', Response::HTTP_CONFLICT);
            }
        }
    }

    public function storeUse($couponId, $customerId): CouponUse
    {
        return CouponUse::create([
            'coupon_id' => $couponId,
            'customer_id' => $customerId
        ]);
    }

    public function incrementUse(int|Coupon $coupon): void
    {
        $coupon = $coupon instanceof Coupon ? $coupon : $this->getBy($coupon);
        $coupon->increment('current_uses');
    }

    public function decrementUse(int|Coupon $coupon): void
    {
        $coupon = $coupon instanceof Coupon ? $coupon : $this->getBy($coupon);
        $coupon->decrement('current_uses');
    }
}