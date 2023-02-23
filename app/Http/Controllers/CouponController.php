<?php

namespace App\Http\Controllers;

use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use Illuminate\Http\Response;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();

        return CouponResource::collection($coupons);
    }

    public function store(StoreCouponRequest $request)
    {
        $coupon = Coupon::create($request->validated());

        return CouponResource::make($coupon);
    }

    public function show(Coupon $coupon)
    {
        return CouponResource::make($coupon);
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $coupon->fill($request->validated());
        $coupon->save();

        return CouponResource::make($coupon);
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return response()->setStatusCode(Response::HTTP_NO_CONTENT);
    }
}
