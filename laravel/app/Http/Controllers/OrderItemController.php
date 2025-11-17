<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\Order;


class OrderItemController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'orders_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric',
        ]);

        $product = Product::findOrFail($request->product_id);
        $order = Order::findOrFail($request->orders_id);

        // Calculate new totals
        $requestQuantitycount = $request->quantity;
        $requestItemFinalAmount = $product->price - $product->discount;
        $itemsTotalAmount = $request->price;

        $order->items_count += 1;
        $order->total_quantity += $requestQuantitycount;
        $order->net_amount += $itemsTotalAmount;
        $order->total_amount += $itemsTotalAmount;


        $orderItem = OrderItems::create([
            'orders_id'    => $request->orders_id,
            'product_id'   => $product->id,
            'quantity'     => $request->quantity,
            'net_amount'   => $product->price,
            'discount'     => $product->discount,
            'final_amount' => $requestItemFinalAmount,
            'total_amount' => $itemsTotalAmount,
            'status'       => 1
        ]);

        // Save updated order
        $order->save();

        return response()->json([
            'success' => 'Product added successfully',
            'orderItem' => $orderItem
        ]);
    }


    public function inActiveItems(Request $request)
    {
        $item = OrderItems::findOrFail($request->id);
        $order = Order::findOrFail($item->orders_id);

        if (!$item) {
            return response()->json(['error' => 'Item not found'], 404);
        }

        // Update order totals
        $requestItemcount = $item->quantity;
        $requestItemamount = $item->total_amount;

        $order->items_count -= 1;
        $order->total_quantity -= $requestItemcount;
        $order->net_amount -= $requestItemamount;
        $order->total_amount -= $requestItemamount;

        $item->softDelete(); // status=0, deleted_at update aagum
        $order->save();

        return response()->json(['success' => 'Item deleted successfully']);
    }
}
