<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('id','DESC')->paginate(10);
        return view('backend.order.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|string',
        'email'    => 'required|email',
        'phone'    => 'required|numeric',
        'address1' => 'required|string',
        'address2' => 'nullable|string',
        'post_code'=> 'nullable|string',
        'remarks'  => 'nullable|string',

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
        $orderData['shipping_id'] = $request->shipping ?? null;

        // Shipping price
        $shippingPrice = $request->shipping ? Shipping::find($request->shipping)->price : 0;

        // Cart totals
        $orderData['net_amount'] = Helper::totalCartPrice();
        $orderData['total_quantity'] = Helper::cartCount();
        $orderData['items_count'] = $cartItems->count();

        // Coupon discount
        $orderData['discount'] = session('coupon')['value'] ?? 0;

        // Total amount including shipping & discount
        $orderData['total_amount'] = $orderData['net_amount'] + $shippingPrice - $orderData['discount'];

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

        $order->fill($orderData);
        $order->save();

        // Assign cart items to this order
        Cart::where('user_id', auth()->user()->id)
            ->where('order_id', null)
            ->update(['order_id' => $order->id]);

        // Notify admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $details = [
                'title'     => 'New order created',
                'actionURL' => route('order.show', $order->id),
                'fas'       => 'fa-file-alt',
            ];
            Notification::send($admin, new StatusNotification($details));
        }

        session()->forget(['cart', 'coupon']);
        session()->flash('success', 'Your order has been placed successfully.');

        if ($request->payment_method === 'paypal') {
            return redirect()->route('payment')->with(['id' => $order->id]);
        }

        return redirect()->route('home');
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('backend.order.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('backend.order.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $this->validate($request, [
            'status' => 'required|in:active,pending,completed,returned,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        session()->flash('success', 'Order updated successfully.');
        return redirect()->route('order.index');
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
            session()->flash('success', 'Order deleted successfully.');
        } else {
            session()->flash('error', 'Order not found.');
        }
        return redirect()->route('order.index');
    }

    public function orderTrack()
    {
        return view('frontend.pages.order-track');
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
}