<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index($slug = null)
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

        $products = [];
        if ($selectedCategory) {
            $products = Product::where('status', 'active')
                ->where('cat_id', $selectedCategory->id)
                ->orderBy('id', 'desc')
                ->get();
        }

        return Inertia::render('Category/Index', [
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'products' => $products,
        ]);
    }
}
