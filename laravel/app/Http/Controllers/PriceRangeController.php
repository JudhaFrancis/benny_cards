<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PriceRange;


class PriceRangeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Order by min_price (lowest first), then max_price
    $priceRanges = PriceRange::orderBy('min_price', 'asc')
        ->orderBy('max_price', 'asc')
        ->paginate();

    return view('backend.price_range.index', compact('priceRanges'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.price_range.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'min_price' => 'nullable|integer',
            'max_price' => 'nullable|integer',
            'photo' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $slug = generateUniqueSlug($request->title, PriceRange::class);
        $validatedData['slug'] = $slug;

        $priceRange = PriceRange::create($validatedData);

        $message = $priceRange
            ? 'Price Range successfully added'
            : 'Error occurred, Please try again!';

        return redirect()->route('price-range.index')->with(
            $priceRange ? 'success' : 'error',
            $message
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $priceRange = PriceRange::findOrFail($id);
        return view('backend.price_range.edit', compact('priceRange'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $priceRange = PriceRange::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'min_price' => 'nullable|integer',
            'max_price' => 'nullable|integer',
            'photo' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $status = $priceRange->update($validatedData);

        $message = $status
            ? 'Price Range successfully updated'
            : 'Error occurred, Please try again!';

        return redirect()->route('price-range.index')->with(
            $status ? 'success' : 'error',
            $message
        );

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $priceRange = PriceRange::findOrFail($id);
        $status = $priceRange->delete();

        $message = $status
            ? 'Price Range successfully deleted'
            : 'Error while deleting Price Range';

        return redirect()->route('price-range.index')->with(
            $status ? 'success' : 'error',
            $message
        );
    }
}
