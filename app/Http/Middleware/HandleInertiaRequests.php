<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

use App\Models\Setting;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'settings' => Setting::first(),
            'categories' => \App\Models\Category::where('status', 'active')->get(),
            'wishlist' => $request->user()
                ? \App\Models\Wishlist::where('user_id', $request->user()->id)
                    ->with('product')
                    ->latest()
                    ->get()
                : [],
            'cart' => $request->user()
                ? \App\Models\Cart::where('user_id', $request->user()->id)
                    ->where('status', 'new')
                    ->with('product')
                    ->latest()
                    ->get()
                : [],
            'cart_count' => $request->user()
                ? \App\Models\Cart::where('user_id', $request->user()->id)
                    ->where('status', 'new')
                    ->sum('quantity')
                : 0,
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
        ];
    }
}
