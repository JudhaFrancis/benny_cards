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
                @php $rate = ceil($product_detail->getReview->avg('rate')); @endphp
                @for($i=1;$i<=5;$i++) <i class="fa {{ $rate >= $i ? 'fa-star' : 'fa-star-o' }}"></i>
                    @endfor
                    <span>({{ $product_detail['getReview']->count() }} Reviews)</span>
            </div>

            @php
            $after_discount = $product_detail->price - (($product_detail->price * $product_detail->discount) / 100);
            @endphp
            <div class="product-prices">
                ₹{{ number_format($after_discount, 2) }}
                @if($product_detail->discount > 0)
                <s>₹{{ number_format($product_detail->price, 2) }}</s>
                @endif
            </div>

            <p class="product-summary">{!! $product_detail->summary !!}</p>

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
                    <span class="meta-value category-name">
                        <a href="{{ route('product-cat', $product_detail->cat_info['slug']) }}">
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
            <div id="desc" class="tab-content-clean active">
                {!! $product_detail->description !!}
            </div>

            <div id="reviews" class="tab-content-clean">
                <div class="reviews-container">
                    <p class="reviews-subtitle">See what others are saying about this card.</p>

                    <div class="reviews-summary">
                        <div class="rating-left">
                            <h1>4.8</h1>
                            <div class="stars">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-half-o"></i>
                            </div>
                            <p>Based on 125 reviews</p>
                        </div>

                        <div class="rating-bars">
                            <div class="bar-row"><span>5</span>
                                <div class="bar">
                                    <div class="fill" style="width:85%"></div>
                                </div><span>85%</span>
                            </div>
                            <div class="bar-row"><span>4</span>
                                <div class="bar">
                                    <div class="fill" style="width:10%"></div>
                                </div><span>10%</span>
                            </div>
                            <div class="bar-row"><span>3</span>
                                <div class="bar">
                                    <div class="fill" style="width:3%"></div>
                                </div><span>3%</span>
                            </div>
                            <div class="bar-row"><span>2</span>
                                <div class="bar">
                                    <div class="fill" style="width:1%"></div>
                                </div><span>1%</span>
                            </div>
                            <div class="bar-row"><span>1</span>
                                <div class="bar">
                                    <div class="fill" style="width:1%"></div>
                                </div><span>1%</span>
                            </div>
                        </div>

                        <button class="btn-write-review"><i class="fa fa-pencil"></i> Write a Review</button>
                    </div>

                    <!-- Reviews Item -->


                    <div class="review-item">
                        <div class="review-left">
                            <div class="review-user">
                                <img src="https://i.pravatar.cc/40" alt="User" class="review-avatar">
                                <div>
                                    <strong>Jessica L.</strong>
                                    <p class="review-date">October 26, 2023</p>
                                </div>
                            </div>
                            <h4 class="review-title">Absolutely beautiful card!</h4>
                            <p class="review-text">
                                The paper quality is fantastic and the design is even more vibrant in person.
                                It was perfect for my friend's birthday and she loved it. Highly recommend!
                            </p>
                        </div>
                        <div class="review-right">
                            <div class="review-rating">★★★★★</div>
                            <img src="https://images.unsplash.com/photo-1511988617509-a57c8a288659?w=600"
                                alt="Review Image" class="review-image">
                        </div>
                    </div>

                    <!-- Review Item 2 -->
                    <div class="review-item">
                        <div class="review-left">
                            <div class="review-user">
                                <img src="https://i.pravatar.cc/41" alt="User" class="review-avatar">
                                <div>
                                    <strong>Rahul K.</strong>
                                    <p class="review-date">November 8, 2023</p>
                                </div>
                            </div>
                            <h4 class="review-title">Loved the quality and design!</h4>
                            <p class="review-text">
                                It’s really elegant and classy. The print is crisp and the colors are so rich.
                                The envelope was also very premium. Perfect for gifting!
                            </p>
                        </div>
                        <div class="review-right">
                            <div class="review-rating">★★★★☆</div>
                            <img src="https://images.unsplash.com/photo-1569867037406-6b9ad775b22e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"
                                alt="Review Image" class="review-image">
                        </div>
                    </div>

                    <!-- Review Item 3 -->
                    <div class="review-item">
                        <div class="review-left">
                            <div class="review-user">
                                <img src="https://i.pravatar.cc/42" alt="User" class="review-avatar">
                                <div>
                                    <strong>Meena P.</strong>
                                    <p class="review-date">October 15, 2023</p>
                                </div>
                            </div>
                            <h4 class="review-title">Best card I’ve bought this year!</h4>
                            <p class="review-text">
                                This card looks even better than in the photos. The design feels luxurious,
                                and delivery was quick. I’ll definitely order more soon!
                            </p>
                        </div>
                        <div class="review-right">
                            <div class="review-rating">★★★★★</div>
                            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600"
                                alt="Review Image" class="review-image">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

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

                        @if($data->stock <= 0) <span class="badge out-of-stock">Sold Out</span>
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
</script>

@endpush