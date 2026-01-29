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

<!-- Wedding Cards by Religion Section -->
<section class="section">
    <div class="section-container">
        <div class="section-title">
            <h2>Wedding Invitations by Religion</h2>
        </div>

        <!-- Use the same swiper class -->
        <div class="swiper product-items-swiper">
            <div class="swiper-wrapper">
                @php
                $category_lists = DB::table('categories')->where('status','active')->where('is_parent',1)->get();
                @endphp
                @foreach($category_lists as $cat)
                <div class="swiper-slide" style="padding-bottom: 20px;">
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
                </div>
                @endforeach
            </div>

            <!-- Navigation Arrows -->
            <div class="swiper-navigation text-center mt-3">
                <div class="swiper-button-prev d-inline-block me-2"></div>
                <div class="swiper-button-next d-inline-block"></div>
            </div>
        </div>
    </div>
</section>

<!-- End Small Banner -->

<!-- All categories -->
<section class="trending-products-section section" style="padding-top: 0px;">
    <div class="section-container">
        <!-- Section Title -->
        <div class="row position-relative mb-3">
            <div class="col-12">
                <div class="section-title">
                    <h2>All Categories</h2>
                </div>

                <button class="btn btn-dark filter-btn" id="filterBtn">
                    Filters <i class="ti-filter"></i>
                </button>
            </div>
        </div>

        <!-- Tab Nav -->
        <div class="filter-wrapper mb-4">
            <button class="scroll-arrow left" id="scrollLeft">‹</button>

            <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                @php
                $categories = DB::table('categories')->where('status','active')->where('is_parent',1)->get();
                @endphp
                @foreach($categories as $cat)
                <button class="btn" data-filter=".{{$cat->id}}">
                    {{$cat->title}}
                </button>
                @endforeach
            </ul>

            <button class="scroll-arrow right" id="scrollRight">›</button>
        </div>


        <!-- Products Grid -->
        <div class="row trending-products-grid isotope-grid">
            @foreach($product_lists as $key => $product)
            @php
            $photo = explode(',', $product->photo);
            $after_discount = ($product->price - ($product->price * $product->discount) / 100);
            $newProductIds = $product_lists->sortByDesc('created_at')->take(20)->pluck('id')->toArray();
            @endphp
            <div class="col-6 col-sm-6 col-md-4 col-lg-3 isotope-item {{$product->cat_id}}">
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <a href="{{ route('product-detail', $product->slug) }}">
                            <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                        </a>
                        @if($product->condition == 'trending')
                        <span class="badge trending">Trending</span>
                        @elseif(in_array($product->id, $newProductIds))
                        <span class="badge new">New</span>
                        @elseif($product->condition == 'hot')
                        <span class="badge hot">Hot</span>
                        @endif

                        <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-top"><i
                                class="ti-heart"></i></a>
                        <a href="{{ route('add-to-cart', $product->slug) }}" class="btn-add-cart-bottom">Add to Cart</a>
                    </div>

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

        <!-- Swiper Slider using same class as Trending Items -->
        <div class="swiper product-items-swiper">
            <div class="swiper-wrapper">
                @php
                $price_ranges = DB::table('price_ranges')->where('status','active')->get();
                @endphp
                @foreach($price_ranges as $price)
                <div class="swiper-slide">
                    <div class="product-card-modern">
                        <div class="price-card-new">
                            <div class="price-image-new">
                                <img src="{{ $price->photo ?? 'https://via.placeholder.com/400x400' }}"
                                    alt="{{ $price->title }}">
                                <div class="ribbon">Starting at ₹{{ $price->min_price }}</div>
                            </div>
                            <div class="price-content-new text-center">
                                <h4 class="price-title-new">{{ $price->title }}</h4>
                                <a href="{{ route('price-range.products', $price->slug) }}" class="price-btn-new">Shop
                                    Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Navigation arrows -->
            <div class="swiper-navigation text-center mt-3">
                <div class="swiper-button-prev d-inline-block me-2"></div>
                <div class="swiper-button-next d-inline-block"></div>
            </div>
        </div>
    </div>
</section>

<!-- End Price Range Section -->

<!-- Start Trending Items -->
@php
$trendingProducts = $product_lists->where('condition', 'trending');
@endphp

@if($trendingProducts->count() > 0)
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Trending Items</h2>
                </div>
            </div>
        </div>

        <!-- Swiper Slider -->
        <div class="swiper product-items-swiper">
            <div class="swiper-wrapper">
                @foreach($trendingProducts as $product)
                @php
                $photo = explode(',', $product->photo);
                $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                @endphp

                <div class="swiper-slide">
                    <div class="product-card-modern">
                        <div class="product-image-modern">
                            <a href="{{ route('product-detail', $product->slug) }}">
                                <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                            </a>

                            @if($product->condition == 'trending')
                            <span class="badge trending">Trending</span>
                            @endif

                            <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-top"><i
                                    class="ti-heart"></i></a>
                            <a href="{{ route('add-to-cart', $product->slug) }}" class="btn-add-cart-bottom">Add to
                                Cart</a>
                        </div>

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
                @endforeach
            </div>

            <!-- Navigation Arrows BELOW the slider -->
            <div class="swiper-navigation text-center mt-3">
                <div class="swiper-button-prev d-inline-block me-2"></div>
                <div class="swiper-button-next d-inline-block"></div>
            </div>

        </div>

    </div>
</section>
@endif

<!-- Start Latest Items -->
@php
// Get the 20 most recently created products
$newProducts = $product_lists->sortByDesc('created_at')->take(20);
@endphp

@if($newProducts->count() > 0)
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Latest Items</h2>
                </div>
            </div>
        </div>

        <!-- Swiper Slider -->
        <div class="swiper product-items-swiper">
            <div class="swiper-wrapper">
                @foreach($newProducts as $product)
                @php
                $photo = explode(',', $product->photo);
                $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                @endphp

                <div class="swiper-slide">
                    <div class="product-card-modern">
                        <div class="product-image-modern">
                            <a href="{{ route('product-detail', $product->slug) }}">
                                <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                            </a>

                            <!-- Always show "New" badge -->
                            <span class="badge new">New</span>

                            <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-top">
                                <i class="ti-heart"></i>
                            </a>
                            <a href="{{ route('add-to-cart', $product->slug) }}" class="btn-add-cart-bottom">
                                Add to Cart
                            </a>
                        </div>

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
                @endforeach
            </div>

            <!-- Navigation Arrows BELOW the slider -->
            <div class="swiper-navigation text-center mt-3">
                <div class="swiper-button-prev d-inline-block me-2"></div>
                <div class="swiper-button-next d-inline-block"></div>
            </div>
        </div>
    </div>
</section>
@endif


<!-- Start Hot Items -->
@php
$hotProducts = $product_lists->where('condition', 'hot');
@endphp

@if($hotProducts->count() > 0)
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Hot Items</h2>
                </div>
            </div>
        </div>

        <!-- Swiper Slider -->
        <div class="swiper product-items-swiper">
            <div class="swiper-wrapper">
                @foreach($hotProducts as $product)
                @php
                $photo = explode(',', $product->photo);
                $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                @endphp

                <div class="swiper-slide">
                    <div class="product-card-modern">
                        <div class="product-image-modern">
                            <a href="{{ route('product-detail', $product->slug) }}">
                                <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                            </a>

                            @if($product->stock <= 0) <span class="badge out-of-stock">Sold Out</span>
                                @elseif($product->condition == 'hot')
                                <span class="badge hot">Hot</span>
                                @endif

                                <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-top"><i
                                        class="ti-heart"></i></a>
                                <a href="{{ route('add-to-cart', $product->slug) }}" class="btn-add-cart-bottom">Add to
                                    Cart</a>
                        </div>

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
                @endforeach
            </div>

            <!-- Navigation Arrows BELOW the slider -->
            <div class="swiper-navigation text-center mt-3">
                <div class="swiper-button-prev d-inline-block me-2"></div>
                <div class="swiper-button-next d-inline-block"></div>
            </div>

        </div>
    </div>

</section>
@endif

<!-- End Shop Home List  -->
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const scrollContainer = document.querySelector('.filter-tope-group');
    const btnLeft = document.getElementById('scrollLeft');
    const btnRight = document.getElementById('scrollRight');

    const scrollAmount = 150; // adjust scroll distance per click

    btnLeft.addEventListener('click', () => {
        scrollContainer.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
    });

    btnRight.addEventListener('click', () => {
        scrollContainer.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    });

    // hide/show arrows dynamically
    function toggleArrows() {
        btnLeft.style.display = scrollContainer.scrollLeft > 10 ? 'block' : 'none';
        btnRight.style.display =
            scrollContainer.scrollWidth - scrollContainer.scrollLeft >
            scrollContainer.clientWidth + 10 ? 'block' : 'none';
    }

    scrollContainer.addEventListener('scroll', toggleArrows);
    toggleArrows();
});

$(document).ready(function() {
    var $topeContainer = $('.isotope-grid');

    // Initialize Isotope and keep the instance in $grid
    var $grid = $topeContainer.isotope({
        itemSelector: '.isotope-item',
        layoutMode: 'fitRows',
        percentPosition: true,
        animationEngine: 'best-available',
        masonry: {
            columnWidth: '.isotope-item'
        }
    });

    // Function to limit visible items to maxItems (e.g., 8)
    function limitVisibleItems(maxItems) {
        var visibleItems = $grid.data('isotope').filteredItems;

        visibleItems.forEach(function(item, index) {
            if (index < maxItems) {
                $(item.element).show();
            } else {
                $(item.element).hide();
            }
        });

        $grid.isotope('layout');

        // Handle "no products" message
        if (visibleItems.length === 0) {
            if ($('.no-products-message').length === 0) {
                $topeContainer.append(`
                    <div class="col-12 text-center no-products-message mt-2">
                        <p class="text-muted fs-5">No products available in this category right now.</p>
                    </div>
                `);
            }
        } else {
            $('.no-products-message').remove();
        }
    }

    // On filter button click
    $('.filter-tope-group').on('click', 'button', function() {
        var filterValue = $(this).attr('data-filter');

        // Filter with Isotope
        $grid.isotope({
            filter: filterValue
        });

        // After filtering, limit visible items to 8
        $grid.one('arrangeComplete', function() {
            limitVisibleItems(8);
        });

        // Toggle active classes
        $('.filter-tope-group button').removeClass('how-active1 active');
        $(this).addClass('how-active1 active');
    });

    // Default filter on page load: show all and limit to 8
    $grid.isotope({
        filter: '*'
    });

    $grid.one('arrangeComplete', function() {
        limitVisibleItems(8);
        $('.filter-tope-group button[data-filter="*"]').addClass('how-active1 active');
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

function cancelFullScreen(el) {
    var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el.exitFullscreen;
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
};

document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.product-items-swiper', {
        slidesPerView: 4,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            0: {
                slidesPerView: 2
            },
            576: {
                slidesPerView: 2.1
            },
            768: {
                slidesPerView: 3.1
            },
            992: {
                slidesPerView: 4.1
            },
        }
    });
});

document.getElementById("filterBtn").addEventListener("click", function () {
    sessionStorage.setItem("openFilterDrawer", "1");
    window.location.href = "{{ route('product-grids') }}";
});


</script>

@endpush