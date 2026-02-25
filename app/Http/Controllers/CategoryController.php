<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(Request $request, $slug = null)
    {
        $categories = Category::where('status', 'active')
            ->withCount([
                'products' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->get();

        $selectedCategory = null;
        if ($slug) {
            $selectedCategory = Category::where('slug', $slug)->first();
        } else if ($categories->isNotEmpty()) {
            $selectedCategory = $categories->first();
        }

        if (!$selectedCategory) {
            abort(404);
        }

        $query = Product::where('status', 'active')
            ->where('cat_id', $selectedCategory->id);

        // Filtering
        if ($request->brands) {
            $brandIds = explode(',', $request->brands);
            $query->whereIn('brand_id', $brandIds);
        }

        if ($request->price_range) {
            $range = \App\Models\PriceRange::where('slug', $request->price_range)->first();
            if ($range) {
                if ($range->min_price !== null) {
                    $query->where('price', '>=', $range->min_price);
                }
                if ($range->max_price !== null) {
                    $query->where('price', '<=', $range->max_price);
                }
            }
        }

        // Sorting
        $sortBy = $request->input('sortBy', 'newest');
        switch ($sortBy) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->get();

        return Inertia::render('Category/Index', [
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'products' => $products,
            'brands' => \App\Models\Brand::where('status', 'active')->get(),
            'priceRanges' => \App\Models\PriceRange::where('status', 'active')->get(),
            'filterState' => [
                'brands' => $request->brands ? explode(',', $request->brands) : [],
                'price_range' => $request->price_range ?? '',
                'sortBy' => $sortBy,
            ]
        ]);
    }
}
