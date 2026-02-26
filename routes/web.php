<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\PriceRange;

Route::get('/', function () {
    $banners = Banner::where('status', 'active')->orderBy('id', 'desc')->get();
    $products = Product::where('status', 'active')
        ->where('condition', 'new')
        ->orderBy('id', 'desc')
        ->limit(8)
        ->get();

    // Fetch categories with product counts
    $categories = Category::where('status', 'active')
        ->withCount([
            'products' => function ($query) {
                $query->where('status', 'active');
            }
        ])
        ->limit(8)
        ->get();

    // Fetch invitation cards (type: card)
    $invitationCards = Product::where('status', 'active')
        ->where('type', 'card')
        ->limit(8)
        ->get();

    // Fetch gifts (type: gift)
    $gifts = Product::where('status', 'active')
        ->where('type', 'gift')
        ->limit(8)
        ->get();

    // Fetch price ranges and calculate product counts
    $dbPriceRanges = PriceRange::where('status', 'active')->limit(8)->get();
    $priceRanges = $dbPriceRanges->map(function ($range) {
        $query = Product::where('status', 'active');

        if ($range->min_price !== null) {
            $query->where('price', '>=', $range->min_price);
        }

        if ($range->max_price !== null) {
            $query->where('price', '<=', $range->max_price);
        }

        return [
            'label' => $range->title,
            'slug' => $range->slug,
            'min' => $range->min_price,
            'max' => $range->max_price,
            'photo' => $range->photo, // Using trait to get URL
            'count' => $query->count()
        ];
    });

    // Fetch featured products
    $featuredProducts = Product::where('status', 'active')
        ->where('is_featured', 1)
        ->limit(8)
        ->get();

    return Inertia::render('Home', [
        'banners' => $banners,
        'products' => $products,
        'categories' => $categories,
        'invitationCards' => $invitationCards,
        'gifts' => $gifts,
        'priceRanges' => $priceRanges,
        'featuredProducts' => $featuredProducts,
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/category/{slug?}', [\App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');

Route::get('/product/{slug}', [\App\Http\Controllers\ProductController::class, 'show'])->name('product.show');
Route::post('/product/{product}/review', [\App\Http\Controllers\ProductReviewController::class, 'store'])->name('product.review.store');



Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/my-orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
});

Route::post('/contact', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:30',
        'message' => 'required|string|max:5000',
    ]);

    Mail::to('judha@itoi.org')->send(new ContactMail($request->all()));

    return back()->with('success', 'Thank you! Your message has been sent successfully. We will get back to you soon.');
})->name('contact.submit');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist', [\App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [\App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');

    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{id}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');

    Route::get('/checkout', [\App\Http\Controllers\OrderController::class, 'create'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\OrderController::class, 'store'])->name('checkout.store');
});



require __DIR__ . '/auth.php';
