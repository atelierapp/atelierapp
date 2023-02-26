<?php

namespace App\Http\Controllers;

use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Role;
use App\Services\CouponService;
use Illuminate\Http\Response;

class CouponController extends Controller
{
    public function __construct(
        // private CouponService $couponService
    ) {
        $this->middleware('auth:sanctum');
        $this->middleware('role:' . Role::ADMIN . '|'. Role::SELLER)->only(['index']);
    }

    public function index()
    {
        $coupons = Coupon::filterByRole()->get();

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
