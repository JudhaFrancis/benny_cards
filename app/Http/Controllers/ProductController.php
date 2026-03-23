<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display the specified product.
     *
     * @param  string  $slug
     * @return \Inertia\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with([
                'category',
                'images',
                'reviews' => function ($query) {
                    $query->where('status', 'active')->latest();
                }
            ])
            ->firstOrFail();

        $relatedProducts = Product::where('cat_id', $product->cat_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit(4)
            ->get();

        // Calculate average rating
        $averageRating = '0.0';
        if ($product->reviews->count() > 0) {
            $averageRating = number_format($product->reviews->avg('rating'), 1);
        }

        return Inertia::render('Product/Show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'averageRating' => $averageRating,
            'imageBaseUrl' => rtrim(env('VITE_IMAGE_BASE_URL'), '/') . '/reviews/',
        ]);
    }
}
