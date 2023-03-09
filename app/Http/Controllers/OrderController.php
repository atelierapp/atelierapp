<?php

namespace App\Http\Controllers;

use App\Exceptions\AtelierException;
use App\Http\Requests\Order\OrderIndexRequest;
use App\Http\Requests\Order\OrderUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Project;
use App\Models\Role;
use App\Services\OrderService;
use App\Services\PaypalService;
use Illuminate\Http\Request;
use Throwable;

class OrderController extends Controller
{
    public function __construct(
        private PaypalService $paypalService,
        private OrderService $orderService,
    ) {
        $this->middleware('auth:sanctum');
        $this->middleware('role:' . Role::SELLER)->only('accept', 'update');
    }

    public function index(OrderIndexRequest $request)
    {
        $orders = Order::applyFilters($request->validated())
            ->filterByRole()
            ->with(['user', 'seller', 'seller_status', 'paidStatus'])
            ->latest()
            ->get();

        return OrderResource::collection($orders);
    }

    /**
     * @throws Throwable
     * @throws AtelierException
     */
    public function store(Request $request)
    {
        $order = $this->orderService->createFromShoppingCart((int) auth()->id(), $request->get('coupon'));

        if (request()->has('project_id')) {
            /** @var Project $project */
            $project = Project::find(request('project_id'));
            $project->orders[] = $order->id;
            $project->save();
        }

        return $this->paypalService->createOrder($order);
    }

    public function show($order)
    {
        $order = $this->orderService->getByAuthRole($order);
        $order->load('user', 'seller');

        return OrderResource::make($order);
    }

    public function update(OrderUpdateRequest $request, $order)
    {
        $order = $this->orderService->updateSellerStatus($order, $request->get('seller_status_id'));

        return OrderResource::make($order);
    }
}
