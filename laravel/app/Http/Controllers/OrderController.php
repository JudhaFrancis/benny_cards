<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\OrderItems;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;


class OrderController extends Controller
{
    protected $whatsApp;

    public function __construct(WhatsAppService $whatsApp)
    {
        $this->whatsApp = $whatsApp;
    }
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        return view('backend.order.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|string',
            'phone'    => 'required|numeric',
            'address_1' => 'required|string',

        ]);

        $cartItems = Cart::where('user_id', auth()->user()->id)
            ->where('order_id', null)
            ->get();

        if ($cartItems->isEmpty()) {
            session()->flash('error', 'Cart is Empty!');
            return back();
        }

        $order = new Order();
        $orderData = $request->all();

        $orderData['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        $orderData['tracking_id'] = 'TRK-' . strtoupper(Str::random(10));
        $orderData['user_id'] = auth()->user()->id;
        // $orderData['shipping_id'] = $request->shipping ?? null;
        $orderData['order_date'] = now();


        // Shipping price
        $shippingPrice = $request->shipping ? Shipping::find($request->shipping)->price : 0;

        // Cart totals
        $orderData['net_amount'] = Helper::totalCartPrice();
        $orderData['total_quantity'] = $cartItems->sum('quantity');
        $orderData['items_count'] = $cartItems->count();

        // Coupon discount
        $orderData['discount'] = session('coupon')['value'] ?? 0;
        $orderData['coupons_id'] = session('coupon')['id'] ?? null;


        // Total amount including shipping & discount
        $orderData['total_amount'] = $orderData['net_amount'] + $shippingPrice - $orderData['discount'];
        $orderData['paid_amount'] = 0;

        // Payment
        if ($request->payment_method === 'paypal') {
            $orderData['payment_method'] = 'paypal';
            $orderData['payment_status'] = 'paid';
        } else {
            $orderData['payment_method'] = 'cash';
            $orderData['payment_status'] = 'unpaid';
        }

        // Combine first_name + last_name for your 'name' column
        $orderData['name'] = $request->name;

        // Default order status
        $orderData['status'] = 'pending';
        $orderData['tracking_status_id'] = 1; // Default: Pending (from tracking_status table)


        $order->fill($orderData);
        $order->save();

        // Save each cart item into order_items table
        foreach ($cartItems as $cart) {
            $product = \App\Models\Product::find($cart->product_id);


            OrderItems::create([
                'orders_id'    => $order->id,
                'product_id'   => $product->id,
                'net_amount'   => $product->price,
                'discount'     => $product->discount ?? 0,
                'final_amount' => $product->price - ($product->discount ?? 0),
                'quantity'     => $cart->quantity,
                'total_amount' => ($product->price - ($product->discount ?? 0)) * $cart->quantity,
            ]);
        }

        // Assign cart items to this order
        Cart::where('user_id', auth()->user()->id)
            ->where('order_id', null)
            ->update(['order_id' => $order->id]);

        // Notify User via WhatsApp
        try {
            $whatsAppData = [
                'customerName' => $request->name,
                'mobile_no' => $request->phone,
                'order_id' => $orderData['order_number'],
            ];

            $whatsappSentRes = $this->whatsApp->send($whatsAppData, true, 1);

            // Optionally log success or response
            Log::info('WhatsApp notification sent', $whatsappSentRes);
        } catch (\Throwable $e) {
            // Log the error but do not break the order flow
            Log::error('WhatsApp notification failed: ' . $e->getMessage());
        }


        session()->forget(['cart', 'coupon']);
        session()->flash('success', 'Your order has been placed successfully.');

        if ($request->payment_method === 'paypal') {
            return redirect()->route('payment')->with(['id' => $order->id]);
        }

$whatsappNumber = '919003701265'; // Replace with the number you want to redirect to (in international format, no '+' or dashes)

$whatsappUrl = "https://wa.me/{$whatsappNumber}";

return redirect()->away($whatsappUrl);    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('backend.order.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);

        $orderItems = OrderItems::where('orders_id', $order->id)
            ->where('status', 1)
            ->get();
        return view('backend.order.edit',  [
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'tracking_id' => $request->tracking_id,
            'payment_status' => $request->payment_status,
            'status' => $request->status,
            'order_date' => $request->order_date,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'country' => $request->country,
            'post_code' => $request->post_code,
            'remarks' => $request->remarks,
            'discount' => $request->discount,
        ]);

        //EXISTING ITEMS
        if (!empty($request->items)) {
            foreach ($request->items as $itemId => $itemData) {

                $item = OrderItems::find($itemId);

                // Only update if item exists and status = 1
                if ($item && $item->status == 1) {
                    $qty = $itemData['quantity'];
                    $price = $itemData['final_amount'];
                    $item->update([
                        'quantity' => $qty,
                        'final_amount' => $price,
                        'total_amount' => $qty * $price
                    ]);
                }
            }
        }

        $items = OrderItems::where('orders_id', $order->id)
            ->where('status', 1)
            ->get();
        $order->items_count = $items->count();
        $order->total_quantity = $items->sum('quantity');
        $order->net_amount = $items->sum('total_amount');
        $order->total_amount = ($items->sum('total_amount') ?? 0) - ($order->discount ?? 0);

        $order->save();

        return back()->with('success', 'Order updated successfully!');
    }




    public function destroy($id)
    {
        $order = Order::find($id);

        // Update status instead of deleting
        $status = $order->update([
        'status' => 'cancelled'
        ]);
        $message = $status
           ? 'Order successfully marked as cancelled'
           : 'Error while updating order status';

        return redirect()->route('order.index')->with(
            $status ? 'success' : 'error',
        $message
        );
    }

    public function orderTrack($id)
    {
        $order = Order::with('items.product')
            ->findOrFail($id);

        return view('frontend.pages.order-track', compact('order'));
    }


    public function productTrackOrder(Request $request)
    {
        $order = Order::where('user_id', auth()->user()->id)
            ->where('order_number', $request->order_number)
            ->first();

        if (!$order) {
            session()->flash('error', 'Invalid order number.');
            return back();
        }

        switch ($order->status) {
            case 'pending':
                session()->flash('success', 'Your order has been placed. Please wait.');
                break;
            case 'active':
                session()->flash('success', 'Your order is being processed.');
                break;
            case 'completed':
                session()->flash('success', 'Your order has been delivered successfully.');
                break;
            case 'returned':
            case 'cancelled':
                session()->flash('error', 'Your order has been cancelled.');
                break;
        }

        return redirect()->route('home');
    }

    public function myOrders()
    {
        $userId = auth()->id();

        $orders = Order::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.pages.my-orders', compact('orders'));
    }
}
