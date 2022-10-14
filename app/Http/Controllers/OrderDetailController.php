<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderDetailResource;
use App\Models\OrderDetail;
use App\Models\Role;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function index(int|string $order)
    {
        $details = $this->orderService->getDetails($order);

        return OrderDetailResource::collection($details);
    }

    public function update(Request $request, $order, $detail)
    {
        if (! \Bouncer::is(request()->user())->a(Role::SELLER)) {
            return $this->response([], __('authorization.without_access'), 401);
        }

        $detail = OrderDetail::whereId($detail)->firstOrFail();
        $values = [
            'seller_status_id' => $request->get('seller_status_id'),
        ];
        if ($request->has('seller_status_id')) {
            $values['seller_status_at'] = now();
        }

        $values['seller_notes'] = $request->get('seller_notes');

        $detail->update($values);

        return OrderDetailResource::make($detail);
    }
}
