@extends('frontend.layouts.master')
@section('title','BENNY CARDS || HOME PAGE')
@section('main-content')
<!-- Slider Area -->
@if(count($banners)>0)
<section id="Gslider" class="carousel slide" data-ride="carousel" data-interval="3000">
    <ol class="carousel-indicators">
        @foreach($banners as $key=>$banner)
        <li data-target="#Gslider" data-slide-to="{{$key}}" class="{{(($key==0)? 'active' : '')}}"></li>
        @endforeach

    </ol>
    <div class="carousel-inner" role="listbox">
        @foreach($banners as $key=>$banner)
        <div class="carousel-item {{(($key==0)? 'active' : '')}}">
            <img class="first-slide" src="{{$banner->photo}}" alt="First slide">
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
        <span class="carousel-control-ne    xt-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</section>
@endif

<!--/ End Slider Area -->

<!-- Start Small Banner  -->
<!-- Wedding Cards by Religion Section -->
<section class="section">
    <div class="section-container ">
        <div class="section-title">
            <h2>Wedding Invitations by Religion</h2>
        </div>
        <div class="category-grid-modern">
            @php
            $category_lists = DB::table('categories')->where('status','active')->where('is_parent',1)->get();
            @endphp
            @foreach($category_lists as $cat)
            <div class="category-card-modern">
                <div class="category-image-modern">
                    @if($cat->photo)
                    <img src="{{ $cat->photo }}" alt="{{ $cat->title }}">
                    @else
                    <img src="https://via.placeholder.com/400x400" alt="{{ $cat->title }}">
                    @endif
                    <a href="{{ route('product-cat', $cat->slug) }}" class="view-more-text">
                        View More <span class="arrow">→</span>
                    </a>
                </div>
                <div class="category-content-modern">
                    <h4 class="category-title">{{ $cat->title }}</h4>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- End Small Banner -->

<!-- All categories -->
<section class="trending-products-section section" style="padding-top: 0px;">
    <div class="section-container">
        <!-- Section Title -->
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>All Categories</h2>
                </div>
            </div>
        </div>

        <!-- Tab Nav -->
        <ul class="nav nav-tabs filter-tope-group mb-4" id="myTab" role="tablist">
            @php
            $categories = DB::table('categories')->where('status','active')->where('is_parent',1)->get();
            @endphp
            @if($categories)
            <button class="btn active" style="background:none;color:black;" data-filter="*">All Categories</button>
            @foreach($categories as $key=>$cat)
            <button class="btn" style="background:none;color:black;" data-filter=".{{$cat->id}}">
                {{$cat->title}}
            </button>
            @endforeach
            @endif
        </ul>

        <!-- Products Grid -->
        <div class="row trending-products-grid isotope-grid">
            @foreach($categories as $key => $cat)
            @php
            $productsByCategory = $product_lists->where('cat_id', $cat->id)->take(8);
            @endphp

            @foreach($productsByCategory as $product)
            @php
            $photo = explode(',', $product->photo);
            $after_discount = ($product->price - ($product->price * $product->discount) / 100);
            @endphp
            <div class="col-sm-6 col-md-4 col-lg-3 isotope-item {{$product->cat_id}}">
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <a href="{{ route('product-detail', $product->slug) }}">
                            <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                        </a>

                        <!-- Badges -->
                        @if($product->stock <= 0) <span class="badge out-of-stock">Sold Out</span>
                            @elseif($product->condition == 'trending')
                            <span class="badge trending">Trending</span>
                            @elseif($product->condition == 'new')
                            <span class="badge new">New</span>
                            @elseif($product->condition == 'hot')
                            <span class="badge hot">Hot</span>
                            @endif

                            <!-- Wishlist -->
                            <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-top"><i
                                    class="ti-heart"></i></a>
                            <!-- Add to Cart -->
                            <a href="{{ route('add-to-cart', $product->slug) }}" class="btn-add-cart-bottom">Add to
                                Cart</a>
                    </div>

                    <!-- Product Info -->
                    <div class="product-info-modern text-center">
                        <h3 class="product-title">
                            <a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                        </h3>
                        <div class="product-price d-flex justify-content-center align-items-center gap-2">
                            <span class="current-price">₹{{ number_format($after_discount, 2) }}</span>
                            @if($product->discount > 0)
                            <del class="text-muted">₹{{ number_format($product->price, 2) }}</del>
                            <span class="badge discount-badge">{{ $product->discount }}% Off</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @if($productsByCategory->count() == 0)
            <div class="col-12 text-center no-products-message" style="display:none;">
                <p class="text-muted fs-5">No products available in this category right now.</p>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>

<!-- Start Midium Banner  -->
<section class="midium-banner section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            @if($featured)
            @foreach($featured as $data)
            <!-- Single Banner  -->
            <div class="col-lg-6 col-md-6 col-12">
                <div class="single-banner">
                    @php $photo=explode(',',$data->photo); @endphp
                    <img src="{{$photo[0]}}" alt="{{$photo[0]}}">
                    <div class="content-split">
                        <div class="text-left">
                            <p>{{$data->cat_info['title']}}</p>
                            <h3>{{$data->title}} <br>Up to <span>{{$data->discount}}%</span></h3>
                        </div>
                        <div class="button-right">
                            <a href="{{route('product-detail',$data->slug)}}">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /End Single Banner  -->
            @endforeach
            @endif
        </div>
    </div>
</section>
<!-- End Midium Banner -->


<!-- Start Price Range Section -->
<section class="price-range section">
    <div class="section-container">
        <div class="section-title">
            <h2>Price Range</h2>
        </div>
        <div class="price-grid-new">
            @php
            $price_ranges = DB::table('price_ranges')->where('status','active')->get();
            @endphp
            @foreach($price_ranges as $price)
            <div class="price-card-new">
                <div class="price-image-new">
                    <img src="{{ $price->photo ?? 'https://via.placeholder.com/400x400' }}" alt="{{ $price->title }}">
                    <div class="ribbon">Starting at ₹{{ $price->min_price }}</div>
                </div>
                <div class="price-content-new">
                    <h4 class="price-title-new">{{ $price->title }}</h4>
                    <a href="{{ route('price-range.products', $price->slug) }}" class="price-btn-new">Shop Now</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- End Price Range Section -->

<!-- Start Trending Items -->
@php
$trendingItems = $product_lists->where('condition','new');
@endphp
@if($trendingItems->count() > 0)
<!-- Trending Item Area Start -->
@if($product_lists->where('condition', 'trending')->count() > 0)
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center mb-4">
                    <h2>Trending Items</h2>
                </div>
            </div>
        </div>

        <div class="trending-slider">
            @foreach($product_lists as $product)
            @if($product->condition == 'trending')
            @php
            $photo = explode(',', $product->photo);
            $after_discount = ($product->price - ($product->price * $product->discount) / 100);
            @endphp

            <div class="product-card-modern text-center px-2">
                <div class="product-image-modern position-relative">
                    <a href="{{ route('product-detail', $product->slug) }}">
                        <img src="{{ $photo[0] }}" alt="{{ $product->title }}" style="width:100%;border-radius:12px;">
                    </a>

                    @if($product->stock <= 0) <span class="badge out-of-stock">Sold Out</span>
                        @elseif($product->condition == 'new')
                        <span class="badge new">New</span>
                        @elseif($product->condition == 'hot')
                        <span class="badge hot">Hot</span>
                        @elseif($product->condition == 'trending')
                        <span class="badge trending">Trending</span>
                        @endif

                        <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-top"><i
                                class="ti-heart"></i></a>
                        <a href="{{ route('add-to-cart', $product->slug) }}" class="btn-add-cart-bottom">Add to Cart</a>
                </div>

                <div class="product-info-modern mt-3">
                    <h3 class="product-title">
                        <a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                    </h3>
                    <div class="product-price">
                        <span class="current-price fw-bold text-dark">₹{{ number_format($after_discount, 2) }}</span>
                        @if($product->discount > 0)
                        <del class="text-muted small">₹{{ number_format($product->price, 2) }}</del>
                        <span class="badge discount-badge">{{ $product->discount }}% Off</span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        <div class="trending-slider-nav text-center mt-3">
            <button class="trending-prev  mx-2">&lt;</button>
            <button class="trending-next  mx-2">&gt;</button>
        </div>
    </div>
</section>
@endif
<!-- Trending Item Area End -->

@endif


<!-- Start Latest Items -->
<!-- Start Trending Items -->
@php
$latestItems = $product_lists->where('condition','new');
@endphp
@if($latestItems->count() > 0)
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Latest Items</h2>
                </div>
            </div>
        </div>

        <div class="row">
            @php $hasTrending = false; @endphp
            @foreach($product_lists as $product)
            @if($product->condition == 'new')
            @php
            $hasTrending = true;
            $photo = explode(',', $product->photo);
            $after_discount = ($product->price - ($product->price * $product->discount) / 100);
            @endphp

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <a href="{{ route('product-detail', $product->slug) }}">
                            <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                        </a>

                        <!-- Badges (except discount) -->
                        @if($product->stock <= 0) <span class="badge out-of-stock">Sold Out</span>
                            @elseif($product->condition == 'new')
                            <span class="badge new">New</span>
                            @elseif($product->condition == 'hot')
                            <span class="badge hot">Hot</span>
                            @elseif($product->condition == 'trending')
                            <span class="badge trending">Trending</span>
                            @endif

                            <!-- Wishlist Top Right -->
                            <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-top">
                                <i class="ti-heart"></i>
                            </a>

                            <!-- Add to Cart Bottom Right -->
                            <a href="{{ route('add-to-cart', $product->slug) }}" class="btn-add-cart-bottom">
                                Add to Cart
                            </a>
                    </div>

                    <!-- Product Info -->
                    <div class="product-info-modern text-center">
                        <h3 class="product-title">
                            <a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                        </h3>

                        <div class="product-price d-flex justify-content-center align-items-center gap-2">
                            <span
                                class="current-price fw-bold text-dark">₹{{ number_format($after_discount, 2) }}</span>

                            @if($product->discount > 0)
                            <del class="text-muted small">₹{{ number_format($product->price, 2) }}</del>
                            <span class="badge discount-badge">{{ $product->discount }}% Off</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
@endif


<!-- Start Hot Items -->
@php
$hotItems = $product_lists->where('condition','hot');
@endphp
@if($hotItems->count() > 0)
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Hot Items</h2>
                </div>
            </div>
        </div>

        <div class="row">
            @php $hasTrending = false; @endphp
            @foreach($product_lists as $product)
            @if($product->condition == 'hot')
            @php
            $hasTrending = true;
            $photo = explode(',', $product->photo);
            $after_discount = ($product->price - ($product->price * $product->discount) / 100);
            @endphp

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <a href="{{ route('product-detail', $product->slug) }}">
                            <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                        </a>

                        <!-- Badges (except discount) -->
                        @if($product->stock <= 0) <span class="badge out-of-stock">Sold Out</span>
                            @elseif($product->condition == 'new')
                            <span class="badge new">New</span>
                            @elseif($product->condition == 'hot')
                            <span class="badge hot">Hot</span>
                            @elseif($product->condition == 'trending')
                            <span class="badge trending">Trending</span>
                            @endif

                            <!-- Wishlist Top Right -->
                            <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-top">
                                <i class="ti-heart"></i>
                            </a>

                            <!-- Add to Cart Bottom Right -->
                            <a href="{{ route('add-to-cart', $product->slug) }}" class="btn-add-cart-bottom">
                                Add to Cart
                            </a>
                    </div>

                    <!-- Product Info -->
                    <div class="product-info-modern text-center">
                        <h3 class="product-title">
                            <a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                        </h3>

                        <div class="product-price d-flex justify-content-center align-items-center gap-2">
                            <span
                                class="current-price fw-bold text-dark">₹{{ number_format($after_discount, 2) }}</span>

                            @if($product->discount > 0)
                            <del class="text-muted small">₹{{ number_format($product->price, 2) }}</del>
                            <span class="badge discount-badge">{{ $product->discount }}% Off</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
<<<<<<< HEAD @endif=======>>>>>>> a7e52c3faa7299694fb1684abe1e3bf8a959ca9b
    <!-- End Shop Home List  -->

    <!-- Modal -->
    @if($product_lists)
    @foreach($product_lists as $key=>$product)
    <div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close"
                            aria-hidden="true"></span></button>
                </div>
                <div class="modal-body">
                    <div class="row no-gutters">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <!-- Product Slider -->
                            <div class="product-gallery">
                                <div class="quickview-slider-active">
                                    @php
                                    $photo=explode(',',$product->photo);
                                    // dd($photo);
                                    @endphp
                                    @foreach($photo as $data)
                                    <div class="single-slider">
                                        <img src="{{$data}}" alt="{{$data}}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- End Product slider -->
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-content">
                                <h2>{{$product->title}}</h2>
                                <div class="quickview-ratting-review">
                                    <div class="quickview-ratting-wrap">
                                        <div class="quickview-ratting">
                                            {{-- <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="fa fa-star"></i> --}}
                                            @php
                                            $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                            $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                            @endphp
                                            @for($i=1; $i<=5; $i++) @if($rate>=$i)
                                                <i class="yellow fa fa-star"></i>
                                                @else
                                                <i class="fa fa-star"></i>
                                                @endif
                                                @endfor
                                        </div>
                                        <a href="#"> ({{$rate_count}} customer review)</a>
                                    </div>
                                    <div class="quickview-stock">
                                        @if($product->stock >0)
                                        <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} in stock</span>
                                        @else
                                        <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} out
                                            stock</span>
                                        @endif
                                    </div>
                                </div>
                                @php
                                $after_discount=($product->price-($product->price*$product->discount)/100);
                                @endphp
                                <h3><small><del class="text-muted">₹{{number_format($product->price,2)}}</del></small>
                                    ${{number_format($after_discount,2)}} </h3>
                                <div class="quickview-peragraph">
                                    <p>{!! html_entity_decode($product->summary) !!}</p>
                                </div>
                                @if($product->size)
                                <div class="size">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <h5 class="title">Size</h5>
                                            <select>
                                                @php
                                                $sizes=explode(',',$product->size);
                                                // dd($sizes);
                                                @endphp
                                                @foreach($sizes as $size)
                                                <option>{{$size}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <div class="col-lg-6 col-12">
                                                        <h5 class="title">Color</h5>
                                                        <select>
                                                            <option selected="selected">orange</option>
                                                            <option>purple</option>
                                                            <option>black</option>
                                                            <option>pink</option>
                                                        </select>
                                                    </div> --}}
                                    </div>
                                </div>
                                @endif
                                <form action="{{route('single-add-to-cart')}}" method="POST" class="mt-4">
                                    @csrf
                                    <div class="quantity">
                                        <!-- Input Order -->
                                        <div class="input-group">
                                            <div class="button minus">
                                                <button type="button" class="btn btn-primary btn-number"
                                                    disabled="disabled" data-type="minus" data-field="quant[1]">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </div>
                                            <input type="hidden" name="slug" value="{{$product->slug}}">
                                            <input type="text" name="quant[1]" class="input-number" data-min="1"
                                                data-max="1000" value="1">
                                            <div class="button plus">
                                                <button type="button" class="btn btn-primary btn-number"
                                                    data-type="plus" data-field="quant[1]">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!--/ End Input Order -->
                                    </div>
                                    <div class="add-to-cart">
                                        <button type="submit" class="btn">Add to cart</button>
                                        <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn min"><i
                                                class="ti-heart"></i></a>
                                    </div>
                                </form>
                                <div class="default-social">
                                    <!-- ShareThis BEGIN -->
                                    <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
    <!-- Modal end -->
    @endsection

    @push('styles')
    <style>
    /* Banner Sliding */
    #Gslider .carousel-inner {
        background: #000000;
        color: black;
    }

    #Gslider .carousel-inner {
        height: 550px;
    }

    #Gslider .carousel-inner img {
        width: 100% !important;
        opacity: .8;
        height: 550px;
        object-fit: cover;
    }

    #Gslider .carousel-inner .carousel-caption {
        bottom: 60%;
    }

    #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 50px;
        font-weight: bold;
        line-height: 100%;
        color: #F7941D;
    }

    #Gslider .carousel-inner .carousel-caption p {
        font-size: 18px;
        color: black;
        margin: 28px 0 28px 0;
    }

    #Gslider .carousel-indicators {
        bottom: 70px;
    }

    .category-card {
        border: none;
        overflow: hidden;
        position: relative;
        width: 180px;
        height: 200px;
        border-radius: 0;

    }

    .category-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .5s ease;
    }



    .category-card:hover img {
        transform: scale(1.1);
    }

    .category-card .btn {
        background: #F7941D;
        border: none;
        font-weight: 600;
        font-size: 9px;
        padding: 2px 6px;
        color: white;
        position: absolute;
        bottom: 10px;
        right: 10px;
        border-radius: 24px;
    }


    .category-card .card-img-overlay {
        background: rgba(0, 0, 0, 0.1);

    }

    .category-card .card-img-overlay h5,
    .category-card .card-img-overlay p {
        color: #fff;
        font-weight: 600;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
    }

    .price-card {
        border: none;
        overflow: hidden;
        position: relative;
        width: 250px;
        height: 250px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        transition: transform .3s ease-in-out;
    }

    .price-card:hover img {
        transform: scale(1.1);
    }

    .price-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.8;
    }

    .price-card .card-img-overlay {
        background: rgba(0, 0, 0, 0.5);
    }

    .price-card .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #fff;
    }

    .price-card .btn {
        background: #f7941d;
        color: #fff;
        font-weight: 500;
        font-size: 14px;
        padding: 6px 20px;
        border-radius: 30px;
        border: none;
        display: inline-block;
    }
    </style>
    @endpush
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
    /*==================================================================
        [ Isotope ]*/
    var $topeContainer = $('.isotope-grid');
    var $filter = $('.filter-tope-group');

    // filter items on button click
    $filter.each(function() {
        $filter.on('click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $topeContainer.isotope({
                filter: filterValue
            });
        });

    });

    // init Isotope
    $(window).on('load', function() {
        var $grid = $topeContainer.each(function() {
            $(this).isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows',
                percentPosition: true,
                animationEngine: 'best-available',
                masonry: {
                    columnWidth: '.isotope-item'
                }
            });
        });
    });

    var isotopeButton = $('.filter-tope-group button');

    $(isotopeButton).each(function() {
        $(this).on('click', function() {
            for (var i = 0; i < isotopeButton.length; i++) {
                $(isotopeButton[i]).removeClass('how-active1');
            }

            $(this).addClass('how-active1');
        });
    });

    function setEqualHeight() {
        var maxHeight = 0;
        $('.product-card-modern').css('height', 'auto'); // reset

        $('.product-card-modern').each(function() {
            var cardHeight = $(this).outerHeight();
            if (cardHeight > maxHeight) {
                maxHeight = cardHeight;
            }
        });

        $('.product-card-modern').css('height', maxHeight + 'px');
    }

    // Run on page load and window resize
    $(document).ready(setEqualHeight);
    $(window).resize(setEqualHeight);
    </script>
    <script>
    function cancelFullScreen(el) {
        var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el
            .exitFullscreen;
        if (requestMethod) { // cancel full screen.
            requestMethod.call(el);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
    }

    function requestFullScreen(el) {
        // Supports most browsers and their versions.
        var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el
            .msRequestFullscreen;

        if (requestMethod) { // Native full screen.
            requestMethod.call(el);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
        return false
    }
    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('.filter-tope-group .btn');
        const products = document.querySelectorAll('.isotope-item');
        const productsGrid = document.querySelector('.trending-products-grid');

        // Function to filter products
        const filterProducts = (filterValue) => {
            let visibleCount = 0;

            products.forEach(product => {
                if (filterValue === '*' || product.classList.contains(filterValue.substring(1))) {
                    product.style.display = 'block';
                    visibleCount++;
                } else {
                    product.style.display = 'none';
                }
            });

            // Handle "no products" message
            let message = productsGrid.querySelector('.no-products-message');
            if (visibleCount === 0) {
                if (!message) {
                    const msg = document.createElement('div');
                    msg.className = 'col-12 text-center no-products-message mt-2';
                    msg.innerHTML =
                        `<p class="text-muted fs-5">No products available in this category right now.</p>`;
                    productsGrid.appendChild(msg);
                }
            } else if (message) {
                message.remove();
            }
        };

        // Add click listeners to buttons
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove 'active' from all buttons
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');
                filterProducts(filterValue);
            });
        });

        // Default filter on page load (show all)
        const defaultBtn = document.querySelector('.filter-tope-group .btn[data-filter="*"]');
        if (defaultBtn) {
            defaultBtn.classList.add('active');
            filterProducts('*');
        }
    });
    </script>

    <script>
    var $slider = $('.trending-slider');

    $slider.slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: false,
        arrows: false,
        dots: false,
        infinite: false,
        responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    // Custom arrow controls
    $('.trending-prev').on('click', function() {
        $slider.slick('slickPrev');
    });
    $('.trending-next').on('click', function() {
        $slider.slick('slickNext');
    });
    </script>
    @endpush