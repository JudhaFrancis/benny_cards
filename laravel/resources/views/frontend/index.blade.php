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
        <div class="swiper latest-items-swiper">
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
            @foreach($categories as $cat)
            <button class="btn" style="background:white;color:black;" data-filter=".{{$cat->id}}">
                {{$cat->title}}
            </button>
            @endforeach
        </ul>

        <!-- Products Grid -->
        <div class="row trending-products-grid isotope-grid">
            @foreach($product_lists as $key => $product)
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
                        @if($product->stock <= 0)
                            <span class="badge out-of-stock">Sold Out</span>
                            @elseif($product->condition == 'trending')
                            <span class="badge trending">Trending</span>
                            @elseif($product->condition == 'new')
                            <span class="badge new">New</span>
                            @elseif($product->condition == 'hot')
                            <span class="badge hot">Hot</span>
                            @endif

                            <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-top"><i class="ti-heart"></i></a>
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
$trendingProducts = $product_lists->where('condition', 'trending');
@endphp

@if($trendingProducts->count() > 0)
<section class="product-area most-popular section" style="padding-top:0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Trending Items</h2>

                    <div class="hot-slider-nav text-center mt-3">
                        <button class="hot-prev mx-2">&lt;</button>
                        <button class="hot-next mx-2">&gt;</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Swiper Slider -->
        <div class="swiper latest-items-swiper">
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

                            @if($product->stock <= 0)
                                <span class="badge out-of-stock">Sold Out</span>
                                @elseif($product->condition == 'new')
                                <span class="badge new">New</span>
                                @elseif($product->condition == 'hot')
                                <span class="badge hot">Hot</span>
                                @elseif($product->condition == 'trending')
                                <span class="badge trending">Trending</span>
                                @endif

                                <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-top"><i class="ti-heart"></i></a>
                                <a href="{{ route('add-to-cart', $product->slug) }}" class="btn-add-cart-bottom">Add to Cart</a>
                        </div>

                        <div class="product-info-modern text-center">
                            <h3 class="product-title">
                                <a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                            </h3>
                            <div class="product-price d-flex justify-content-center align-items-center gap-2">
                                <span class="current-price fw-bold text-dark">₹{{ number_format($after_discount, 2) }}</span>
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

<!-- Start New Items -->
@php
$newProducts = $product_lists->where('condition', 'new');
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
        <div class="swiper latest-items-swiper">
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

                            @if($product->stock <= 0)
                                <span class="badge out-of-stock">Sold Out</span>
                                @elseif($product->condition == 'new')
                                <span class="badge new">New</span>
                                @elseif($product->condition == 'hot')
                                <span class="badge hot">Hot</span>
                                @elseif($product->condition == 'trending')
                                <span class="badge trending">Trending</span>
                                @endif

                                <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-top"><i class="ti-heart"></i></a>
                                <a href="{{ route('add-to-cart', $product->slug) }}" class="btn-add-cart-bottom">Add to Cart</a>
                        </div>

                        <div class="product-info-modern text-center">
                            <h3 class="product-title">
                                <a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                            </h3>
                            <div class="product-price d-flex justify-content-center align-items-center gap-2">
                                <span class="current-price fw-bold text-dark">₹{{ number_format($after_discount, 2) }}</span>
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
        <div class="swiper latest-items-swiper">
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

                            @if($product->stock <= 0)
                                <span class="badge out-of-stock">Sold Out</span>
                                @elseif($product->condition == 'new')
                                <span class="badge new">New</span>
                                @elseif($product->condition == 'hot')
                                <span class="badge hot">Hot</span>
                                @elseif($product->condition == 'trending')
                                <span class="badge trending">Trending</span>
                                @endif

                                <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn-wishlist-top"><i class="ti-heart"></i></a>
                                <a href="{{ route('add-to-cart', $product->slug) }}" class="btn-add-cart-bottom">Add to Cart</a>
                        </div>

                        <div class="product-info-modern text-center">
                            <h3 class="product-title">
                                <a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                            </h3>
                            <div class="product-price d-flex justify-content-center align-items-center gap-2">
                                <span class="current-price fw-bold text-dark">₹{{ number_format($after_discount, 2) }}</span>
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
    document.addEventListener('DOMContentLoaded', () => {
        const filterButtons = document.querySelectorAll('.filter-tope-group .btn');
        const products = Array.from(document.querySelectorAll('.isotope-item'));
        const productsGrid = document.querySelector('.trending-products-grid');

        const filterProducts = (filterValue) => {
            let visibleCount = 0;

            products.forEach(product => {
                if (filterValue === '*' || product.classList.contains(filterValue.substring(1))) {
                    // Show only first 8 matching products
                    if (visibleCount < 8) {
                        product.style.display = 'block';
                        visibleCount++;
                    } else {
                        product.style.display = 'none';
                    }
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
                    msg.innerHTML = `<p class="text-muted fs-5">No products available in this category right now.</p>`;
                    productsGrid.appendChild(msg);
                }
            } else if (message) {
                message.remove();
            }
        };

        // Add click listeners
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');
                filterProducts(filterValue);
            });
        });

        // Default: show first 8 products on page load
        filterProducts('*');
    });
    document.addEventListener('DOMContentLoaded', () => {
        new Swiper('.latest-items-swiper', {
            slidesPerView: 4,
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.1
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

    // Default filter on page load (show all)
    const defaultBtn = document.querySelector('.filter-tope-group .btn[data-filter="*"]');
    if (defaultBtn) {
        defaultBtn.classList.add('active');
        filterProducts('*');
    }
});
</script>

@endpush