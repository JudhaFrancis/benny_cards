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
<section class="shop single section">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <!-- Product Slider -->
                        <div class="product-gallery">
                            <!-- Images slider -->
                            <div class="flexslider-thumbnails">
                                <ul class="slides">

                                    <li data-thumb="{{ $product_detail->photo }}" rel="adjustX:10, adjustY:" class="image-slide">
                                        <div class="main-image-wrapper rounded border overflow-hidden">
                                            <img src="{{ $product_detail->photo }}" alt="Main Product Image" class="img-fluid w-100 h-auto image" style="object-fit: cover; max-height: 500px;">
                                        </div>
                                    </li>

                                    @if($product_detail->images && count($product_detail->images) > 0)
                                    @foreach($product_detail->images as $img)
                                    <li data-thumb="{{ $img->image_path }}" rel="adjustX:10, adjustY:">
                                        <img src="{{ $img->image_path }}" alt="Product Thumbnail">
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <!-- End Product slider -->
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="product-des">
                            <!-- Description -->
                            <div class="short">
                                <h4>{{$product_detail->title}}</h4>
                                <div class="rating-main">
                                    <ul class="rating">
                                        @php
                                        $rate=ceil($product_detail->getReview->avg('rate'))
                                        @endphp
                                        @for($i=1; $i<=5; $i++) @if($rate>=$i)
                                            <li><i class="fa fa-star"></i></li>
                                            @else
                                            <li><i class="fa fa-star-o"></i></li>
                                            @endif
                                            @endfor
                                    </ul>
                                    <a href="#" class="total-review">({{$product_detail['getReview']->count()}})
                                        Review</a>
                                </div>
                                @php
                                $after_discount=($product_detail->price-(($product_detail->price*$product_detail->discount)/100));
                                @endphp
                                <p class="price">
                                    <span class="discount">₹{{ number_format($after_discount,2) }}</span>
                                    @if($product_detail->discount > 0)
                                    <s>₹{{ number_format($product_detail->price,2) }}</s>
                                    <span class="discount-badge">{{ $product_detail->discount }}% OFF</span>
                                    @endif
                                </p>



                            </div>
                            <!--/ End Description -->
                            <!-- Color -->
                            {{-- <div class="color">
												<h4>Available Options <span>Color</span></h4>
												<ul>
													<li><a href="#" class="one"><i class="ti-check"></i></a></li>
													<li><a href="#" class="two"><i class="ti-check"></i></a></li>
													<li><a href="#" class="three"><i class="ti-check"></i></a></li>
													<li><a href="#" class="four"><i class="ti-check"></i></a></li>
												</ul>
											</div> --}}
                            <!--/ End Color -->
                            <!-- Size -->
                            @if($product_detail->size)
                            <div class="size mt-4">
                                <h4>Size</h4>
                                <ul>
                                    @php
                                    $sizes=explode(',',$product_detail->size);
                                    // dd($sizes);
                                    @endphp
                                    @foreach($sizes as $size)
                                    <li><a href="#" class="one">{{$size}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <!--/ End Size -->
                            <!-- Product Buy -->
                            <div class="product-buy">
                                <form action="{{route('single-add-to-cart')}}" method="POST">
                                    @csrf
                                    <div class="quantity">
                                        <h6>Quantity :</h6>
                                        <!-- Input Order -->
                                        <div class="input-group">
                                            <div class="button minus">
                                                <button type="button" class="btn btn-primary btn-number"
                                                    disabled="disabled" data-type="minus" data-field="quant[1]">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </div>
                                            <input type="hidden" name="slug" value="{{$product_detail->slug}}">
                                            <input type="text" name="quant[1]" class="input-number" data-min="100"
                                                data-max="10000" value="100" id="quantity">
                                            <div class="button plus">
                                                <button type="button" class="btn btn-primary btn-number"
                                                    data-type="plus" data-field="quant[1]">
                                                    <i class="ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <!--/ End Input Order -->
                                    </div>
                                    <div class="add-to-cart mt-4">
                                        <button type="submit" class="btn">Add to cart</button>
                                        <a href="{{route('add-to-wishlist',$product_detail->slug)}}" class="btn min"><i
                                                class="ti-heart"></i></a>
                                    </div>
                                </form>

                                <h3 class="cat">Category :<a
                                        href="{{route('product-cat',$product_detail->cat_info['slug'])}}">{{$product_detail->cat_info['title']}}</a>
                                </h3>
                                @if($product_detail->sub_cat_info)
                                <h3 class="cat mt-1">Sub Category :<a
                                        href="{{route('product-sub-cat',[$product_detail->cat_info['slug'],$product_detail->sub_cat_info['slug']])}}">{{$product_detail->sub_cat_info['title']}}</a>
                                </h3>
                                @endif
                                <h3 class="availability">Stock : @if($product_detail->stock>0)<span
                                        class="badge badge-success">{{$product_detail->stock}}</span>@else <span
                                        class="badge badge-danger">{{$product_detail->stock}}</span> @endif</h3>
                            </div>
                            <!--/ End Product Buy -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="product-info">
                            <div class="nav-main">
                                <!-- Tab Nav -->
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                            href="#description" role="tab">Description</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews"
                                            role="tab">Reviews</a></li>
                                </ul>
                                <!--/ End Tab Nav -->
                            </div>
                            <div class="tab-content" id="myTabContent">
                                <!-- Description Tab -->
                                <div class="tab-pane fade show active" id="description" role="tabpanel">
                                    <div class="tab-single">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="single-des">
                                                    <p>{!! ($product_detail->description) !!}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Description Tab -->
                                <!-- Reviews Tab -->
                                <div class="tab-pane fade" id="reviews" role="tabpanel">
                                    <div class="tab-single review-panel">
                                        <div class="row">
                                            <div class="col-12">

                                                <!-- Review -->
                                                <div class="comment-review">
                                                    <div class="add-review">
                                                        <h5>Add A Review</h5>
                                                        <p>Your email address will not be published. Required fields are
                                                            marked</p>
                                                    </div>
                                                    <h4>Your Rating <span class="text-danger">*</span></h4>
                                                    <div class="review-inner">
                                                        <!-- Form -->
                                                        @auth
                                                        <form class="form" method="post"
                                                            action="{{route('review.store',$product_detail->slug)}}">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-lg-12 col-12">
                                                                    <div class="rating_box">
                                                                        <div class="star-rating">
                                                                            <div class="star-rating__wrap">
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-5" type="radio"
                                                                                    name="rate" value="5">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-5"
                                                                                    title="5 out of 5 stars"></label>
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-4" type="radio"
                                                                                    name="rate" value="4">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-4"
                                                                                    title="4 out of 5 stars"></label>
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-3" type="radio"
                                                                                    name="rate" value="3">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-3"
                                                                                    title="3 out of 5 stars"></label>
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-2" type="radio"
                                                                                    name="rate" value="2">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-2"
                                                                                    title="2 out of 5 stars"></label>
                                                                                <input class="star-rating__input"
                                                                                    id="star-rating-1" type="radio"
                                                                                    name="rate" value="1">
                                                                                <label
                                                                                    class="star-rating__ico fa fa-star-o"
                                                                                    for="star-rating-1"
                                                                                    title="1 out of 5 stars"></label>
                                                                                @error('rate')
                                                                                <span
                                                                                    class="text-danger">{{$message}}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <div class="form-group">
                                                                        <label>Write a review</label>
                                                                        <textarea name="review" rows="6"
                                                                            placeholder=""></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-12">
                                                                    <div class="form-group button5">
                                                                        <button type="submit"
                                                                            class="btn">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        @else
                                                        <p class="text-center p-5">
                                                            You need to <a href="{{route('login.form')}}"
                                                                style="color:rgb(54, 54, 204)">Login</a> OR <a
                                                                style="color:blue"
                                                                href="{{route('register.form')}}">Register</a>

                                                        </p>
                                                        <!--/ End Form -->
                                                        @endauth
                                                    </div>
                                                </div>

                                                <div class="ratting-main">
                                                    <div class="avg-ratting">
                                                        {{-- @php 
																			$rate=0;
																			foreach($product_detail->rate as $key=>$rate){
																				$rate +=$rate
																			}
																		@endphp --}}
                                                        <h4>{{ceil($product_detail->getReview->avg('rate'))}}
                                                            <span>(Overall)</span>
                                                        </h4>
                                                        <span>Based on {{$product_detail->getReview->count()}}
                                                            Comments</span>
                                                    </div>
                                                    @foreach($product_detail['getReview'] as $data)
                                                    <!-- Single Rating -->
                                                    <div class="single-rating">
                                                        <div class="rating-author">
                                                            @if($data->user_info['photo'])
                                                            <img src="{{$data->user_info['photo']}}"
                                                                alt="{{$data->user_info['photo']}}">
                                                            @else
                                                            <img src="{{asset('backend/img/avatar.png')}}"
                                                                alt="Profile.jpg">
                                                            @endif
                                                        </div>
                                                        <div class="rating-des">
                                                            <h6>{{$data->user_info['name']}}</h6>
                                                            <div class="ratings">

                                                                <ul class="rating">
                                                                    @for($i=1; $i<=5; $i++) @if($data->rate>=$i)
                                                                        <li><i class="fa fa-star"></i></li>
                                                                        @else
                                                                        <li><i class="fa fa-star-o"></i></li>
                                                                        @endif
                                                                        @endfor
                                                                </ul>
                                                                <div class="rate-count">(<span>{{$data->rate}}</span>)
                                                                </div>
                                                            </div>
                                                            <p>{{$data->review}}</p>
                                                        </div>
                                                    </div>
                                                    <!--/ End Single Rating -->
                                                    @endforeach
                                                </div>

                                                <!--/ End Review -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Reviews Tab -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Shop Single -->

<!-- Start Most Popular -->
<div class="product-area most-popular related-product section" style="padding-top: 0px;">
    <div class="section-container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Related Products</h2>
                </div>
            </div>
        </div>
        <!-- Related Products -->
        <div class="row trending-products-grid isotope-grid" style="padding-top: 40px;">
            @foreach($product_detail->rel_prods as $data)
            @php
            $photo = explode(',', $data->photo);
            $after_discount = $data->price - ($data->price * $data->discount / 100);
            @endphp

            <div class="col-sm-6 col-md-4 col-lg-3 isotope-item {{ $data->cat_id }}">
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
    </div>
</div>
<!-- End Most Popular Area -->
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $(document).on('click', '.btn-number', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var fieldName = $(this).attr('data-field');
        var type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseFloat(input.val()) || 0;
        var step = 99;

        var min = parseFloat(input.attr('data-min')) || 100;
        var max = parseFloat(input.attr('data-max')) || 10000;

        if (type === 'minus') {
            let newVal = currentVal - step;
            if (newVal < min) newVal = min;
            input.val(newVal);
        } else if (type === 'plus') {
            let newVal = currentVal + step;
            if (newVal > max) newVal = max;
            input.val(newVal);
        }
    });

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
@endpush