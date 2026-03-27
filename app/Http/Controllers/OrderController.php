<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest('order_date') // Assuming we want newest first, usually based on date or created_at
            ->get();

        return Inertia::render('Profile/Orders', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the checkout page.
     */
    public function create()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->where('order_id', null)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return Inertia::render('Checkout/Index', [
            'cartItems' => $cartItems,
        ]);
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'required|string|max:191',
            'address_1' => 'required|string|max:191',
            'address_2' => 'nullable|string|max:191',
            'remarks' => 'nullable|string',
        ]);

        $user = Auth::user();
        $cartItems = Cart::with('product')
            ->where('user_id', $user->id)
            ->where('order_id', null)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $itemsCount = $cartItems->count();
        $totalQuantity = $cartItems->sum('quantity');
        $totalAmount = $cartItems->sum('amount'); // amount in cart is already price * quantity

        $dateString = now()->format('dmY');
        $orderPrefix = "ORD-{$dateString}-";
        $trackingPrefix = "TRK-{$dateString}-";

        // Find the absolute latest order to determine the next increment, regardless of the date
        $latestOrder = Order::orderBy('id', 'desc')->first();

        $nextIncrement = 1;
        if ($latestOrder) {
            // Get the last number used (priority to order_number, fallback to tracking_number)
            $lastNum = $latestOrder->order_number ?: $latestOrder->tracking_number;

            if ($lastNum) {
                // Extract the increment number from the latest string (e.g. ORD-05022026-X or TRK-05022026-X)
                $parts = explode('-', $lastNum);
                $lastIncrementValue = end($parts);
                if (is_numeric($lastIncrementValue)) {
                    $nextIncrement = intval($lastIncrementValue) + 1;
                }
            }
        }

        $orderNumber = $orderPrefix . $nextIncrement;
        // $trackingNumber = $trackingPrefix . $nextIncrement; // Removed since it's not in the production DB

        // Create the order
        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => $user->id,
            'items_count' => $itemsCount,
            'total_quantity' => $totalQuantity,
            'net_amount' => $totalAmount,
            'total_amount' => $totalAmount,
            'balance_due' => $totalAmount,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'order_date' => now(),
        ]);

        // Save detailed customer info into `order_customer_details` table
        $order->customerDetail()->create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address_1' => $validatedData['address_1'],
            'address_2' => $validatedData['address_2'] ?? null,
            'remarks' => $validatedData['remarks'] ?? null,
        ]);

        // Create order items
        /** @var \App\Models\Cart $cartItem */
        foreach ($cartItems as $cartItem) {
            $order->orderItems()->create([
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->title,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->price,
                'total_price' => $cartItem->amount,
            ]);

            // Optional: Associate cart item with order (if keeping history) or just delete
            $cartItem->update(['order_id' => $order->id, 'status' => 'progress']);
        }

        return redirect()->route('orders.index')->with('success', 'Your order has been placed successfully.');
    }
}
