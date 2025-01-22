<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersCollectionResource;
use App\Http\Services\OrderService;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AdminOrderController extends Controller
{
    public function __construct(protected OrderService $orderService)
    {
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = $this->orderService->getAllOrdersDetails();

        return (new OrdersCollectionResource($orders))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param  StoreOrderRequest $request
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = Order::query()->create($request->validated());
        return (new OrderResource($order))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @param  string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $order = Order::with(
            [
            'orderProduct.product.categorySizePrice',
            'orderProduct.product.menuItem'
            ]
        )->findOrFail($id);
        return (new OrderResource($order))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param  UpdateOrderRequest $request
     * @param  string             $id
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, string $id): JsonResponse
    {
        $order = Order::query()->findOrFail($id);
        $order->update($request->validated());
        return (new OrderResource($order))->response()->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @param  string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $order = Order::query()->findOrFail($id);
        $order->delete();
        return response()->json('Order deleted.')->setStatusCode(Response::HTTP_OK);
    }
}
