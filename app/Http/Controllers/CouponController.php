<?php

namespace App\Http\Controllers;

use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Role;
use App\Services\CouponService;
use Bouncer;
use Illuminate\Http\Response;

class CouponController extends Controller
{
    public function __construct(
        private CouponService $couponService
    ) {
        $this->middleware('auth:sanctum');
        $this->middleware('role:' . Role::ADMIN . '|'. Role::SELLER)->only(['index']);
    }

    public function index()
    {
        $coupons = Coupon::filterByRole()->get();

        return CouponResource::collection($coupons);
    }

    public function store(StoreCouponRequest $request): CouponResource
    {
        $coupon = $this->couponService->create($request->validated(), $request->user()?->store?->id);

        return CouponResource::make($coupon);
    }

    public function show($coupon)
    {
        $coupon = $this->couponService->getBy($coupon);

        return CouponResource::make($coupon);
    }

    public function update(UpdateCouponRequest $request, $coupon)
    {
        $coupon = $this->couponService->update($coupon, $request->validated());

        return CouponResource::make($coupon);
    }

    public function destroy($coupon)
    {
        $this->couponService->delete($coupon);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
