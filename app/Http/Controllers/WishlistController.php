<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->with('product')
            ->latest()
            ->get();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => $wishlist,
            ]);
        }

        return inertia('Wishlist/Index', [
            'wishlist' => $wishlist,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        $user = Auth::user();

        // Check if already in wishlist (including soft deleted)
        $wishlist = Wishlist::withTrashed()
            ->where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($wishlist) {
            if ($wishlist->trashed()) {
                $wishlist->restore();
                $message = 'Product added to wishlist.';
                $status = 'added';
            } else {
                $wishlist->delete();
                $message = 'Product removed from wishlist.';
                $status = 'removed';
            }
        } else {
            Wishlist::create([
                'product_id' => $product->id,
                'user_id' => $user->id,
                'price' => $product->price,
                'quantity' => 1,
                'amount' => $product->price,
            ]);
            $message = 'Product added to wishlist.';
            $status = 'added';
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'wishlist_status' => $status,
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $wishlist->delete();

        return back()->with('success', 'Product removed from wishlist.');
    }
}
