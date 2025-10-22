<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Cart;
use App\Models\Brand;
use App\Models\PriceRange;
use App\User;
use Auth;
use Session;
use Newsletter;
use DB;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
class FrontendController extends Controller
{

    public function index(Request $request)
    {
        return redirect()->route($request->user()->role);
    }

    public function home()
    {
        $featured = Product::where('status', 'active')->where('is_featured', 1)->orderBy('price', 'DESC')->limit(2)->get();
        $posts = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $banners = Banner::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // return $banner;
        $products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(12)->get();
        $category = Category::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'ASC')->get();
        // return $category;
        return view('frontend.index')
            ->with('featured', $featured)
            ->with('posts', $posts)
            ->with('banners', $banners)
            ->with('product_lists', $products)
            ->with('category_lists', $category);
    }
    

    public function aboutUs()
    {
        return view('frontend.pages.about-us');
    }

    public function gifts()
    {
        return view('frontend.pages.gifts');
    }

    public function corporate()
    {
        return view('frontend.pages.corporate');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function productDetail($slug)
    {
        $product_detail = Product::getProductBySlug($slug);
        return view('frontend.pages.product_detail')->with('product_detail', $product_detail);
    }

    public function productGrids()
{
    $products = Product::query();
$category_name = '';

// Category filter
if (!empty($_GET['category'])) {
    $cat_id = Category::where('slug', $_GET['category'])->value('id');
    if ($cat_id) {
        $products->where('cat_id', $cat_id);
        $category_name = Category::where('id', $cat_id)->value('title');
    }
}

// Brand filter
if (!empty($_GET['brand'])) {
    $slugs = explode(',', $_GET['brand']);
    $brand_ids = Brand::whereIn('slug', $slugs)->pluck('id')->toArray();
    $products->whereIn('brand_id', $brand_ids);
}

// Price filter
if (!empty($_GET['price_range'])) {
    $priceSlug = $_GET['price_range'];
    $priceRange = PriceRange::where('slug', $priceSlug)->first();
    if ($priceRange) {
        $products->whereBetween('price', [$priceRange->min_price, $priceRange->max_price]);
    }
}

// Sorting
if (!empty($_GET['sortBy'])) {
    switch ($_GET['sortBy']) {
        case 'price_asc':
            $products->orderBy('price', 'ASC');
            break;

        case 'price_desc':
            $products->orderBy('price', 'DESC');
            break;

        case 'latest':
            $products->where('condition', 'new')->orderBy('id', 'DESC');
            break;

        case 'trending':
            $products->where('condition', 'trending')->orderBy('id', 'DESC');
            break;

        default:
            $products->orderBy('id', 'DESC');
            break;
    }
}


// Pagination
$recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
$products = $products->where('status', 'active')->paginate(!empty($_GET['show']) ? $_GET['show'] : 20);

$allCategories = Category::where('status', 'active')->get();

// Return view
return view('frontend.pages.product-grids', compact('products', 'recent_products', 'category_name','allCategories'));

}

    public function productLists()
    {
        $products = Product::query();

        if (!empty($_GET['category'])) {
    $cat_id = Category::where('slug', $_GET['category'])->value('id');
    if ($cat_id) {
        $products->where('cat_id', $cat_id);
    }
}

        if (!empty($_GET['brand'])) {
    $slugs = explode(',', $_GET['brand']);
    $brand_ids = Brand::whereIn('slug', $slugs)->pluck('id')->toArray();
    $products->whereIn('brand_id', $brand_ids);
}

        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', 'active')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', 'active')->paginate(6);
        }
        // Sort by name , price, category


        return view('frontend.pages.product-lists')->with('products', $products)->with('recent_products', $recent_products);
    }
    public function productFilter(Request $request)
{
    $data = $request->all();

    $showURL = !empty($data['show']) ? '&show=' . $data['show'] : '';
    $sortByURL = !empty($data['sortBy']) ? '&sortBy=' . $data['sortBy'] : '';
    $catURL = !empty($data['category']) ? '&category=' . $data['category'] : '';
    $brandURL = !empty($data['brand']) ? '&brand=' . $data['brand'] : '';
    $priceRangeURL = !empty($data['price_range']) ? '&price_range=' . $data['price_range'] : '';

    // Get category name
    $category_name = '';
    if (!empty($data['category'])) {
        $category_name = Category::where('slug', $data['category'])->value('title');
    }

    // Redirect to product-grids with query string
    return redirect()->route('product-grids', $catURL . $brandURL . $priceRangeURL . $showURL . $sortByURL);
}

    public function productSearch(Request $request)
    {
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $products = Product::orwhere('title', 'like', '%' . $request->search . '%')
            ->orwhere('slug', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('summary', 'like', '%' . $request->search . '%')
            ->orwhere('price', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate('9');
        return view('frontend.pages.product-grids')->with('products', $products)->with('recent_products', $recent_products);
    }

    public function productBrand(Request $request)
    {
        $products = Brand::getProductByBrand($request->slug);
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')->with('products', $products->products)->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')->with('products', $products->products)->with('recent_products', $recent_products);
        }

    }
    public function productCat(Request $request)
    {

        $category = Category::where('slug', $request->slug)->firstOrFail();

        $products = Product::where('cat_id', $category->id)->where('status', 'active')->orderBy('id', 'DESC')->paginate(9);        // return $request->slug;
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        $allCategories = Category::where('status', 'active')->get();

        return view('frontend.pages.product-grids', [
        'products' => $products,
        'recent_products' => $recent_products,
        'category_name' => $category->title,
        'allCategories' => $allCategories,
    ]);

    }

    public function productSubCat(Request $request)
    {
        $products = Category::getProductBySubCat($request->sub_slug);
        // return $products;
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')->with('products', $products->sub_products)->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')->with('products', $products->sub_products)->with('recent_products', $recent_products);
        }

    }

    public function blog()
    {
        $post = Post::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = PostCategory::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            return $cat_ids;
            $post->whereIn('post_cat_id', $cat_ids);
            // return $post;
        }
        if (!empty($_GET['tag'])) {
            $slug = explode(',', $_GET['tag']);
            // dd($slug);
            $tag_ids = PostTag::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // return $tag_ids;
            $post->where('post_tag_id', $tag_ids);
            // return $post;
        }

        if (!empty($_GET['show'])) {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate($_GET['show']);
        } else {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogDetail($slug)
    {
        $post = Post::getPostBySlug($slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        // return $post;
        return view('frontend.pages.blog-detail')->with('post', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogSearch(Request $request)
    {
        // return $request->all();
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $posts = Post::orwhere('title', 'like', '%' . $request->search . '%')
            ->orwhere('quote', 'like', '%' . $request->search . '%')
            ->orwhere('summary', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('slug', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(8);
        return view('frontend.pages.blog')->with('posts', $posts)->with('recent_posts', $rcnt_post);
    }

    public function blogFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $tagURL = "";
        if (!empty($data['tag'])) {
            foreach ($data['tag'] as $tag) {
                if (empty($tagURL)) {
                    $tagURL .= '&tag=' . $tag;
                } else {
                    $tagURL .= ',' . $tag;
                }
            }
        }
        // return $tagURL;
        // return $catURL;
        return redirect()->route('blog', $catURL . $tagURL);
    }

    public function blogByCategory(Request $request)
    {
        $post = PostCategory::getBlogByCategory($request->slug);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post->post)->with('recent_posts', $rcnt_post);
    }

    public function blogByTag(Request $request)
    {
        // dd($request->slug);
        $post = Post::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    // Login
    public function login()
    {
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request)
    {
        $data = $request->all();
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 'active'])) {
            Session::put('user', $data['email']);
            request()->session()->flash('success', 'Successfully login');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Invalid email and password pleas try again!');
            return redirect()->back();
        }
    }

    public function logout()
    {
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success', 'Logout successfully');
        return back();
    }

    public function register()
    {
        return view('frontend.pages.register');
    }
    public function registerSubmit(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'name' => 'string|required|min:2',
            'email' => 'string|required|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);
        $data = $request->all();
        // dd($data);
        $check = $this->create($data);
        Session::put('user', $data['email']);
        if ($check) {
            request()->session()->flash('success', 'Successfully registered');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Please try again!');
            return back();
        }
    }
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active'
        ]);
    }
    // Reset password
    public function showResetForm()
    {
        return view('auth.passwords.old-reset');
    }

    public function subscribe(Request $request)
    {
        if (!Newsletter::isSubscribed($request->email)) {
            Newsletter::subscribePending($request->email);
            if (Newsletter::lastActionSucceeded()) {
                request()->session()->flash('success', 'Subscribed! Please check your email');
                return redirect()->route('home');
            } else {
                Newsletter::getLastError();
                return back()->with('error', 'Something went wrong! please try again');
            }
        } else {
            request()->session()->flash('error', 'Already Subscribed');
            return back();
        }
    }

    public function productPriceRange($slug)
{
    $priceRange = PriceRange::where('slug', $slug)->firstOrFail();

    $products = Product::where('status', 'active')
        ->whereBetween('price', [$priceRange->min_price, $priceRange->max_price])
        ->orderBy('price', 'ASC')
        ->paginate(12);

    $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();

    $category_name = $priceRange->title ?? '';

    $allCategories = Category::where('status', 'active')->get();

    if (request()->is('product-grids') || request()->is('price-range/*')) {
        return view('frontend.pages.product-grids', compact('products', 'recent_products', 'priceRange','category_name','allCategories'));
    } else {
        return view('frontend.pages.product-lists', compact('products', 'recent_products', 'priceRange','category_name','allCategories'));
    }
}

}