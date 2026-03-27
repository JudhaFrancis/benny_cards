<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Get suggestions for the search bar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function suggestions(Request $request)
    {
        $query = $request->query('q', '');

        if (strlen($query) < 2) {
            return response()->json([
                'categories' => [],
                'products' => [],
            ]);
        }

        $categories = Category::where('status', 'active')
            ->where('title', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get();

        $products = Product::where('status', 'active')
            ->where('title', 'LIKE', "%{$query}%")
            ->limit(8)
            ->get();

        return response()->json([
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
