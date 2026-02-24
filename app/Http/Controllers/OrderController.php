<?php

namespace App\Http\Controllers;

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
}
