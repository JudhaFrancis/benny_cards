<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

use Illuminate\Support\Str;

class InvitationCardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cards = Product::with(['cat_info', 'sub_cat_info', 'brand'])
            ->where('type', 'card')
            ->where('status', 'active')
            ->paginate(10);
        return view('backend.invitation_cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::get();
        $categories = Category::where('is_parent', 1)
            ->where('status', 'active')->orderBy('title', 'ASC')
            ->get();
        return view('backend.invitation_cards.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'photo' => 'required|string',
            'size' => 'nullable',
            'stock' => 'nullable|numeric',
            'cat_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot,trending',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
        ]);

        $slug = generateUniqueSlug($request->title, Product::class);
        $validatedData['slug'] = $slug;
        $validatedData['is_featured'] = $request->input('is_featured', 0);

        if ($request->has('size')) {
            $validatedData['size'] = implode(',', $request->input('size'));
        } else {
            $validatedData['size'] = '';
        }

        $product = Product::create($validatedData);

        if ($request->images) {
            $images = explode(',', $request->images);
            foreach ($images as $img) {
                $product->images()->create([
                    'image_path' => $img
                ]);
            }
        }


        $message = $product
            ? 'Product Successfully added'
            : 'Please try again!!';

        return redirect()->route('invitation_cards.index')->with(
            $product ? 'success' : 'error',
            $message
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Implement if needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $brands = Brand::get();
        $product = Product::findOrFail($id);
        $categories = Category::where('is_parent', 1)
            ->where('status', 'active')
            ->orderBy('title', 'ASC')
            ->get();
        $items = Product::where('id', $id)->get();

        return view('backend.invitation_cards.edit', compact('product', 'brands', 'categories', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'summary' => 'required|string',
            'description' => 'nullable|string',
            'photo' => 'required|string',
            'size' => 'nullable',
            'stock' => 'nullable|numeric',
            'cat_id' => 'required|exists:categories,id',
            'child_cat_id' => 'nullable|exists:categories,id',
            'is_featured' => 'sometimes|in:1',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|in:active,inactive',
            'condition' => 'required|in:default,new,hot,trending',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
        ]);

        $validatedData['is_featured'] = $request->input('is_featured', 0);

        if ($request->has('size')) {
            $validatedData['size'] = implode(',', $request->input('size'));
        } else {
            $validatedData['size'] = '';
        }

        $status = $product->update($validatedData);
        if ($request->images) {
            $product->images()->delete();

            $images = explode(',', $request->images);
            foreach ($images as $img) {
                $product->images()->create([
                    'image_path' => $img
                ]);
            }
        }

        $message = $status
            ? 'Product Successfully updated'
            : 'Please try again!!';

        return redirect()->route('invitation_cards.index', ['page' => $request->page])->with(
            $status ? 'success' : 'error',
            $message
        );
    }

    /**
     *  Mark the product as inactive instead of deleting it.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Update status instead of deleting
        $status = $product->update([
            'status' => 'inactive'
        ]);

        $message = $status
            ? 'Product successfully marked as inactive'
            : 'Error while updating product status';

        return redirect()->route('invitation_cards.index')->with(
            $status ? 'success' : 'error',
            $message
        );
    }

    /**
     * Perform live search for active products by title or slug.
     */
    public function search(Request $request)
    {
        $query = $request->get('query', '');

        $products = Product::where('title', 'like', "%{$query}%")
            ->orWhere('slug', 'like', "%{$query}%")
            ->where('status', 'active')
            ->limit(10)
            ->get(['id', 'title', 'price', 'discount', 'photo']);

        return $products;
    }
}
