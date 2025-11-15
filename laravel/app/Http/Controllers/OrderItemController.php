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
        ]);

        $product = Product::findOrFail($request->product_id);
        $order = Order::findOrFail($request->orders_id);
        

$oldItemscount = $order->items_count;
$oldtotalamount = $order->total_amount;
$oldnetamount = $order->net_amount;
$requestItemscount = 1;
$requestItemsamount =$product->price;
$updatedItemscount = $oldItemscount+$requestItemscount;
$qty = $request->quantity;  
$requestItemTotal = $productPrice * $qty;
$updatedTotalAmount = $oldtotalamount + $requestItemTotal;


        print_r($updatedTotalamount);
                return;

                
        $orderItem = OrderItems::create([
        'orders_id'    => $request->orders_id,
        'product_id'   => $product->id,
        'quantity'     => $request->quantity,
        'net_amount'   => $product->price,
        'final_amount' => $product->price,
        'total_amount' => $product->price * $request->quantity,
        'status'       => 1
    ]);
        return response()->json([
            'success' => 'Product added successfully',
            'orderItem' => $orderItem
        ]);
    }

    
   public function destroy(Request $request)
{
    $item = OrderItems::find($request->id);

    if (!$item) {
        return response()->json(['error' => 'Item not found'], 404);
    }

    $item->softDelete(); // status=0, deleted_at update aagum

    return response()->json(['success' => 'Item deleted successfully']);
}

}