<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Notification;
use App\Notifications\StatusNotification;
use App\User;
use App\Models\ProductReview;
class ProductReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews=ProductReview::getAllReview();
        
        return view('backend.review.index')->with('reviews',$reviews);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $products = Product::all(); // fetch all products
    return view('backend.review.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    $this->validate($request, [
        'product_id' => 'required',
        'reviewer_name' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'rating' => 'required|numeric|min:1|max:5',
        'image' => 'nullable|string',
    ]);

    $data = [
        'product_id' => $request->product_id,
        'reviewer_name' => $request->reviewer_name,
        'title' => $request->title,
        'description' => $request->description,
        'rating' => $request->rating,
        'image' => $request->image,   
        'user_id' => auth()->id(),   
    ];

    ProductReview::create($data);

    return redirect()->route('review.index')->with('success', 'Review added successfully!');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review=ProductReview::find($id);
        // return $review;

        if(!$review){
        return redirect()->route('review.index')->with('error', 'Review not found!');
    }

    $products = Product::all(); // fetch all products for select dropdown

    return view('backend.review.edit', compact('review', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $this->validate($request, [
        'product_id' => 'required',
        'reviewer_name' => 'required|string|max:255',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'rating' => 'required|numeric|min:1|max:5',
        'image' => 'nullable|string',
    ]);

    $review = ProductReview::find($id);
    if(!$review) {
        return redirect()->route('review.index')->with('error', 'Review not found!');
    }

    $data = $request->only([
        'product_id',
        'reviewer_name',
        'title',
        'rating',
        'image'
    ]);

    $review->update($data);

    return redirect()->route('review.index')->with('success', 'Review updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review=ProductReview::find($id);
        $status=$review->delete();
        if($status){
            request()->session()->flash('success','Successfully deleted review');
        }
        else{
            request()->session()->flash('error','Something went wrong! Try again');
        }
        return redirect()->route('review.index');
    }
}