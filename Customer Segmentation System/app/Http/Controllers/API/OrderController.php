<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::all();
            return response()->json([
                'status' => true,
                'message' => 'All orders details are here',
                'data' => $orders
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error updating message subject',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(OrderRequest $request)
    {
        try {
            $order = Order::create($request->validated());
            return response()->json([
                'status' => true,
                'message' => 'Order created successfully',
                'data' => $order
            ], 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error updating message subject',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return response()->json([
                'status' => true,
                'message' => 'Order deleted successfully'
            ], 200);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error updating message subject',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
