<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        \Log::info('Review submission attempt', [
            'product_id' => $product->id,
            'has_files' => $request->hasFile('images'),
            'file_count' => $request->hasFile('images') ? count($request->file('images')) : 0,
            'all_data' => $request->all(),
        ]);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'name' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $imageNames = [];
        if ($request->hasFile('images')) {
            $destinationPath = 'C:/xampp/htdocs/benny-cards-admin-panel/public/uploads/reviews';
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($destinationPath, $filename);
                $imageNames[] = $filename;
            }
        }

        ProductReview::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'reviewer_name' => $request->name ?? (auth()->check() ? auth()->user()->name : 'Anonymous'),
            'title' => $request->title,
            'description' => $request->content,
            'rating' => $request->rating,
            'image' => $imageNames, // Will be cast to JSON/array by model
            'status' => 'active',
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}
