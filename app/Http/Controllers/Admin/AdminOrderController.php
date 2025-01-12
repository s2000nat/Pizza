<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class AdminOrderController extends Controller
{

    /**
     * Получить список всех заказов.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = Order::with('user', 'location')->get();
        return response()->json($orders);
    }

    /**
     * Создать новый заказ.
     *
     * @param StoreOrderRequest $request
     * @return JsonResponse
     */
    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = Order::query()->create($request->validated());
        return response()->json($order, 201);
    }

    /**
     * Получить конкретный заказ по ID.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $order = Order::with('user', 'location')->findOrFail($id);
        return response()->json($order);
    }

    /**
     * Обновить заказ по ID.
     *
     * @param UpdateOrderRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, string $id): JsonResponse
    {
        $order = Order::query()->findOrFail($id);
        $order->update($request->validated());
        return response()->json($order);
    }

    /**
     * Удалить заказ по ID.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $order = Order::query()->findOrFail($id);
        $order->delete();
        return response()->json('Заказ успешно удален', 204);
    }
}
