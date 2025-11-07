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

<!-- ===== PRODUCT DETAIL ===== -->
<div class="container">
    <div class="product-page">
        <!-- LEFT -->
        <div class="product-gallery">
            <div style="display:flex;align-items:flex-start;">
                @if($product_detail->images && count($product_detail->images) > 0)
                <div class="thumbnail-list">
                    @foreach($product_detail->images as $img)
                    <img src="{{ $img->image_path }}" alt="thumb"
                        onclick="document.getElementById('mainImage').src='{{ $img->image_path }}'">
                    @endforeach
                </div>
                @endif
                <img id="mainImage" src="{{ $product_detail->photo }}" alt="main image" class="main-image">
            </div>
        </div>

        <!-- RIGHT -->
        <div class="product-info">
            <h2>{{ $product_detail->title }}</h2>

            <div class="rating">
                @php $rate=ceil($product_detail->getReview->avg('rate')) @endphp
                @for($i=1;$i<=5;$i++) @if($rate>=$i)
                    <i class="fa fa-star"></i>
                    @else
                    <i class="fa fa-star-o"></i>
                    @endif
                    @endfor
                    <span>({{ $product_detail['getReview']->count() }} Reviews)</span>
            </div>

            @php
            $after_discount = ($product_detail->price - (($product_detail->price * $product_detail->discount) / 100));
            @endphp
            <p class="price">
                ₹{{ number_format($after_discount, 2) }}
                @if($product_detail->discount > 0)
                <s>₹{{ number_format($product_detail->price, 2) }}</s>
                @endif
            </p>

            <p class="product-description">{!! $product_detail->summary !!}</p>

            <!-- ===== Add to Cart (Outside Card) ===== -->
            <div class="add-cart-bar">
                <form action="{{ route('single-add-to-cart') }}" method="POST" style="display:flex;flex:1;">
                    @csrf
                    <input type="hidden" name="slug" value="{{ $product_detail->slug }}">
                    <button type="submit" class="btn-add-cart">
                        <i class="fa fa-shopping-cart"></i> Add to Cart
                    </button>
                </form>
                <div class="heart-btn">
                    <i class="fa fa-heart-o"></i>
                </div>
            </div>

            <!-- ===== White Card (Below) ===== -->
            <div class="detail-card">
                @if($product_detail->size)
                <div class="size-options">
                    <h6>Size</h6>
                    <div class="size-buttons">
                        @php $sizes = explode(',', $product_detail->size); @endphp
                        @foreach($sizes as $size)
                        <button type="button" class="size-btn">{{ $size }}</button>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="quantity-section">
                    <h6>Quantity</h6>
                    <div class="quantity-wrapper">
                        <button type="button" class="qty-minus">-</button>
                        <input type="number" name="quant[1]" id="quantity" value="1" min="1">
                        <button type="button" class="qty-plus">+</button>
                    </div>
                </div>

                <div class="product-meta">
                    <div class="meta-row">
                        <strong>Stock Status:</strong>
                        @if($product_detail->stock > 0)
                        <span class="stock-green"><i class="fa fa-check-circle"></i> In Stock
                            ({{ $product_detail->stock }})</span>
                        @else
                        <span style="color:red;">Out of Stock</span>
                        @endif
                    </div>
                    <div class="meta-row">
                        <strong>Category:</strong>
                        <span>{{ $product_detail->cat_info['title'] }}</span>
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

<style>
.product-page {
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 8rem;
    padding: 40px 20px;
    max-width: 1100px;
    margin: 0 auto;
}

/* --- Left Side --- */
.product-gallery {
    flex: 0 0 380px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.thumbnail-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: center;
}

.thumbnail-list img {
    width: 60px;
    height: 75px;
    border-radius: 6px;
    object-fit: cover;
    cursor: pointer;
    border: 2px solid transparent;
    transition: 0.3s;
}

.thumbnail-list img:hover {
    border-color: #8A5DFF;
}

.main-image {
    width: 320px;
    height: 420px;
    object-fit: cover;
    border-radius: 12px;
    padding: 18px;
    background: radial-gradient(circle at center, #f4e9ff 0%, #f6f4fb 100%);
    box-shadow: 0 15px 35px rgba(138, 93, 255, 0.25);
    border: 1px solid rgba(138, 93, 255, 0.08);
    transition: all 0.3s ease;
}

.product-info {
    flex: 1;
    max-width: 480px;
}

.product-info h2 {
    font-size: 1.7rem;
    font-weight: 700;
    color: #1c1b2a;
    margin-bottom: 0.6rem;
}

.rating {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 0.5rem;
}

.rating i {
    color: #dc3545;
}

.rating span {
    color: #666;
}

.price {
    font-size: 1.5rem;
    color: #00cec9;
    font-weight: 700;
    margin: 10px 0;
}

.price s {
    color: #888;
    font-size: 1rem;
}

.product-description {
    color: #444;
    line-height: 1.6;
    margin: 15px 0;
}

.product-page {
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    gap: 5rem;
    padding: 40px 20px;
    max-width: 1100px;
    margin: 0 auto;
}

.add-cart-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin: 25px 0;
}

.btn-add-cart {
    flex: 1;
    background: #00cec9;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.heart-btn {
    width: 45px;
    height: 45px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.3s;
}

.heart-btn i {
    font-size: 20px;
    color: #999;
}

.heart-btn:hover i {
    color: #8A5DFF;
}

.detail-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    padding: 28px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.03);
}

/* --- Size --- */
.size-options {
    margin-bottom: 25px;
}

.size-options h6 {
    font-weight: 600;
    font-size: 1.05rem;
    margin-bottom: 10px;
    color: #222;
}

.size-buttons {
    display: flex;
    gap: 10px;
}

.size-buttons button {
    border: 1px solid #ccc;
    border-radius: 8px;
    background: #00cec9;
    padding: 10px 18px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: 0.3s;
    color: #333;
}

/* --- Quantity --- */
.quantity-section {
    margin-bottom: 25px;
}

.quantity-section h6 {
    font-weight: 600;
    font-size: 1.05rem;
    margin-bottom: 10px;
    color: #222;
}

.quantity-wrapper {
    display: flex;
    align-items: center;
    border: 1px solid #eee;
    border-radius: 10px;
    overflow: hidden;
    width: 150px;
}

.quantity-wrapper button {
    width: 45px;
    height: 40px;
    border: none;
    background: #f6f4fb;
    color: #555;
    font-size: 18px;
    cursor: pointer;
}

.quantity-wrapper input {
    width: 60px;
    text-align: center;
    border: none;
    font-weight: 600;
    font-size: 1rem;
}

/* --- Stock & Category Row Layout --- */
.product-meta {
    border-top: 1px solid #eee;
    padding-top: 18px;
    font-size: 0.96rem;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.meta-row strong {
    color: #333;
    font-weight: 600;
}

.meta-row span {
    color: #222;
    font-weight: 500;
}

.stock-green {
    color: #28a745 !important;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 5px;
}

.stock-green i {
    color: #28a745 !important;
}
</style>

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
    var step = 49;

    var min = parseFloat(input.attr('data-min')) || 50;
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