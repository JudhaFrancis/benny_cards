@extends('frontend.layouts.master')

@section('meta')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name='copyright' content=''>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
<meta name="description" content="{{$product_detail->summary}}">
<meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
<meta property="og:type" content="article">
<meta property="og:title" content="{{$product_detail->title}}">
<meta property="og:image" content="{{$product_detail->photo}}">
<meta property="og:description" content="{{$product_detail->description}}">
@endsection
@section('title','BENNY CARDS || PRODUCT DETAIL')
@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>

                        @php
                        // Product category fetch
                        $category = DB::table('categories')->where('id', $product_detail->cat_id)->first();
                        @endphp

                        @if($category)
                        <li>
                            <a href="{{ route('product-cat', $category->slug) }}">
                                {{ $category->title }}<i class="ti-arrow-right"></i>
                            </a>
                        </li>
                        @endif

                        <li class="active">{{ $product_detail->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- End Breadcrumbs -->

<!-- Shop Single -->
<div class="product-page-wrapper">
    <div class="product-page-container">

        <!-- LEFT -->
        <div class="product-left">
            <div class="product-thumbnails">
                @foreach($product_detail->images as $img)
                <img src="{{ $img->image_path }}" alt="thumb"
                    onclick="document.getElementById('mainImage').src='{{ $img->image_path }}'">
                @endforeach
            </div>
            <div class="product-main-image">
                <img id="mainImage" src="{{ $product_detail->photo }}" alt="{{ $product_detail->title }}">
            </div>
        </div>

        <!-- RIGHT -->
        <div class="product-right">
            <h2 class="product-heading">{{ $product_detail->title }}</h2>

            <div class="product-rating">
                @php $rate = ceil($product_detail->getReviews->avg('rate')); @endphp
                @for($i=1;$i<=5;$i++) <i class="fa {{ $rate >= $i ? 'fa-star' : 'fa-star-o' }}"></i>
                    @endfor
                    <span>({{ $product_detail['getReviews']->count() }} Reviews)</span>
            </div>

            @php
            $after_discount = $product_detail->price - (($product_detail->price * $product_detail->discount) / 100);
            @endphp
            <div class="product-prices">
                ₹{{ number_format($after_discount, 2) }}

                @if($product_detail->discount > 0)
                <s>₹{{ number_format($product_detail->price, 2) }}</s>
                <span class="discount">-{{ number_format($product_detail->discount, 0) }}%</span>
                @endif
            </div>

            <p class="product-summary" style="text-align: justify;">{!! $product_detail->summary !!}</p>

            <form action="{{ route('single-add-to-cart') }}" method="POST" class="add-cart-form">
                @csrf
                <input type="hidden" name="slug" value="{{ $product_detail->slug }}">
                <input type="hidden" name="quant[1]" id="quant_value" value="50">

                <button type="submit" class="add-to-cart-btn">
                    <i class="fa fa-shopping-cart"></i> Add to Cart
                </button>
                <a href="{{ route('add-to-wishlist', $product_detail->slug) }}" class="wishlist-btn">
                    <i class="fa fa-heart-o"></i>
                </a>
            </form>


            <div class="product-info-card">
                @if($product_detail->size)
                <div class="product-size">
                    <h6>Size</h6>
                    <div class="size-options">
                        @php $sizes = explode(',', $product_detail->size); @endphp
                        @foreach($sizes as $size)
                        <button type="button" class="size-btn">{{ $size }}</button>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="product-quantity">
                    <h6>Quantity</h6>
                    <div class="qty-box">
                        <button type="button" onclick="changeQty(-1)">-</button>
                        <input type="number" id="quantity" value="50" min="50">
                        <button type="button" onclick="changeQty(1)">+</button>
                    </div>
                </div>

                <div class="meta-row">
                    <span class="meta-label">Stock Status:</span>
                    <span class="meta-value in-stock"><i class="fa fa-check-circle"></i> In Stock
                        ({{ $product_detail->stock }})</span>
                </div>

                <div class="meta-row">
                    <span class="meta-label">Category:</span>
                    <span class="meta-value">
                        <a class="category-name" href="{{ route('product-cat', $product_detail->cat_info['slug']) }}">
                            {{ $product_detail->cat_info['title'] }}
                        </a>
                    </span>
                </div>

            </div>
        </div>
    </div>

    <!-- Description / Customer Reviews -->
    <div class="product-tabs-clean">
        <div class="tab-header-clean">
            <button class="tab-link-clean active" onclick="openTabClean(event,'desc')">Description</button>
            <button class="tab-link-clean" onclick="openTabClean(event,'reviews')">Customer Reviews</button>
        </div>

        <div class="tab-body-clean">
            <div id="desc" class="tab-content-clean active" style="text-align: justify;">
                {!! $product_detail->description !!}
            </div>

            <div id="reviews" class="tab-content-clean">
                <div class="reviews-container">
                    <p class="reviews-subtitle">See what others are saying about <span style="font-weight:600">'{{ $product_detail->title }}'</span> card.</p>

                    <div class="reviews-summary">
                        <div class="rating-left">
                            <h1>{{ number_format($product_detail->getReviews->avg('rate'), 1) }}</h1>
                            @php $rate = ceil($product_detail->getReviews->avg('rate')); @endphp
                            @for($i=1;$i<=5;$i++)
                                <i class="fa {{ $rate >= $i ? 'fa-star' : 'fa-star-o' }}"
                                style="color: {{ $rate >= $i ? '#ec1176' : '#ec1176' }}"></i>
                                @endfor
                                <p>Based on {{ $product_detail->getReviews->count() }} reviews</p>
                        </div>

                        @php
                        $reviews = $product_detail->getReviews;
                        $totalReviews = $reviews->count();
                        $ratingCounts = [
                        5 => $reviews->where('rate', 5)->count(),
                        4 => $reviews->where('rate', 4)->count(),
                        3 => $reviews->where('rate', 3)->count(),
                        2 => $reviews->where('rate', 2)->count(),
                        1 => $reviews->where('rate', 1)->count(),
                        ];
                        $minFill = 2;
                        @endphp

                        <div class="rating-bars">
                            @foreach(range(5, 1) as $star)
                            @php
                            $count = $ratingCounts[$star];
                            $percent = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                            $percent = max($percent, $minFill); // ensure at least $minFill%
                            @endphp
                            <div class="bar-row">
                                <span>{{ $star }}</span>
                                <div class="bar">
                                    <div class="fill" style="width:{{ $percent }}%"></div>
                                </div>
                                <span>{{ $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0 }}%</span>
                            </div>
                            @endforeach
                        </div>

                        <button class="btn-review"><i class="fa fa-pencil"></i> Write a Review</button>
                    </div>

                    <!-- Reviews Items -->
                    @foreach($product_detail->getReviews as $review)
                    <div class="review-item">
                        <div class="review-left">
                            <div class="review-user">
                                <div class="review-avatar rounded-full w-10 h-10 flex items-center justify-center"
                                    style="background-color: #ec1176a1;">
                                    <img src="https://img.icons8.com/3d-fluency/94/000000/businessman.png"
                                        alt="User"
                                        class="w-8 h-8">
                                </div>
                                <div>
                                    <strong>{{ $review->reviewer_name }}</strong>
                                    <p class="review-date">{{ $review->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <h4 class="review-title">{{ $review->title }}</h4>
                            <p class="review-text">
                                {{ $review->review }}
                            </p>
                        </div>
                        <div class="review-right">
                            <div class="review-rating">@for ($i = 1; $i <= 5; $i++)
                                    @if ($i <=$review->rate)
                                    ★
                                    @else
                                    ☆
                                    @endif
                                    @endfor</div>
                            <img src="https://images.unsplash.com/photo-1511988617509-a57c8a288659?w=600"
                                alt="Review Image" class="review-image">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div id="review_form" class="hidden">
                    <p class="reviews-subtitle">Share Your thoughts on the <span style="font-weight:600">'{{ $product_detail->title }}'</span> card.</p>
                    <form class="form" method="post" action="{{route('login.submit')}}">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Email<span>*</span></label>
                                    <input type="email" name="email" placeholder="" required="required"
                                        value="{{old('email')}}">
                                    @error('email')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Your Password<span>*</span></label>
                                    <input type="password" name="password" placeholder="" required="required"
                                        value="{{old('password')}}">
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                    <div>
                        <button class="cancel-btn-review"><i class="fa fa-times"></i> Cancel</button>
                        <button class="btn-review"><i class="fa fa-check"></i> Submit Review</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!--/ End Shop Single -->

<!-- Start Most Popular -->
<div class="product-area section" style="padding-top: 0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Related Products</h2>
                </div>
            </div>
        </div>
        <!-- Related Products -->
        <div class="swiper product-items-swiper">
            <div class="swiper-wrapper">
                @foreach($product_detail->rel_prods as $data)
                @php
                $photo = explode(',', $data->photo);
                $after_discount = $data->price - ($data->price * $data->discount / 100);
                @endphp

                <div class="swiper-slide">
                    <div class="product-card-modern">
                        <div class="product-image-modern">
                            <a href="{{ route('product-detail', $data->slug) }}">
                                <img src="{{ $photo[0] }}" alt="{{ $data->title }}">
                            </a>

                            @if($data->stock <= 0)
                                <span class="badge out-of-stock">Sold Out</span>
                                @elseif($data->condition == 'trending')
                                <span class="badge trending">Trending</span>
                                @elseif($data->condition == 'new')
                                <span class="badge new">New</span>
                                @elseif($data->condition == 'hot')
                                <span class="badge hot">Hot</span>
                                @endif

                                <a href="{{ route('add-to-wishlist', $data->slug) }}" class="btn-wishlist-top">
                                    <i class="ti-heart"></i>
                                </a>
                                <a href="{{ route('add-to-cart', $data->slug) }}" class="btn-add-cart-bottom">
                                    Add to Cart
                                </a>
                        </div>

                        <div class="product-info-modern text-center">
                            <h3 class="product-title">
                                <a href="{{ route('product-detail', $data->slug) }}">{{ $data->title }}</a>
                            </h3>
                            <div class="product-price d-flex justify-content-center align-items-center gap-2">
                                <span class="current-price">₹{{ number_format($after_discount, 2) }}</span>
                                @if($data->discount > 0)
                                <del class="text-muted">₹{{ number_format($data->price, 2) }}</del>
                                <span class="badge discount-badge">{{ $data->discount }}% Off</span>
                                @endif
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
</div>
<!-- End Most Popular Area -->

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    function changeQty(direction) {
        const qtyInput = document.getElementById('quantity');
        const hiddenInput = document.getElementById('quant_value');
        let currentVal = parseInt(qtyInput.value) || 0;
        const min = parseInt(qtyInput.getAttribute('min')) || 50;
        const max = 10000;
        const step = 50;

        if (direction === 1) currentVal = Math.min(max, currentVal + step);
        else currentVal = Math.max(min, currentVal - step);

        qtyInput.value = currentVal;
        hiddenInput.value = currentVal;
    }

    function openTabClean(e, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tab-content-clean");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].classList.remove("active");
        }
        tablinks = document.getElementsByClassName("tab-link-clean");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].classList.remove("active");
        }
        document.getElementById(tabName).classList.add("active");
        e.currentTarget.classList.add("active");
    }

    document.addEventListener('DOMContentLoaded', function() {
        const writeBtn = document.querySelector('.reviews-summary .btn-review'); // Write Review button
        const cancelBtn = document.querySelector('#review_form .cancel-btn-review'); // Cancel button
        const reviewsContainer = document.querySelector('.reviews-container'); // Reviews list
        const reviewForm = document.getElementById('review_form'); // Review form

        // Show form, hide reviews
        writeBtn.addEventListener('click', function() {
            reviewsContainer.classList.add('hidden');
            reviewForm.classList.remove('hidden');
        });

        // Hide form, show reviews
        cancelBtn.addEventListener('click', function() {
            reviewForm.classList.add('hidden');
            reviewsContainer.classList.remove('hidden');
        });
    });

    // cart height
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
    // Swiper
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
</script>

@endpush