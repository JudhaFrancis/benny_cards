@extends('frontend.layouts.master')

@section('title','BENNY CARDS || PRODUCT PAGE')

@section('main-content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{ url('/') }}">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><span>{{ $category_name }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Product Style -->
<div class="container mt-3 mb-3">
    <h3 class="text-start text-uppercase">{{ $category_name }}</h3>
</div>

<form action="{{route('shop.filter')}}" method="POST">
    @csrf
    <section class="product-area shop-sidebar shop section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shop-sidebar d-flex justify-content-between flex-wrap">
                        <!-- Single Widget -->
                        <div class="single-widget category">
                            <h3 class="title">Categories</h3>
                            @php
                            $categories = App\Models\Category::getAllParentWithChild();
                            @endphp
                            <select name="category" class="form-control" onchange="this.form.submit()">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" @if(!empty($_GET['category']) &&
                                    $_GET['category']==$cat->slug) selected @endif>
                                    {{ $cat->title }}
                                </option>
                                @if($cat->child_cat->count() > 0)
                                @foreach($cat->child_cat as $sub)
                                <option value="{{ $sub->slug }}" @if(!empty($_GET['category']) &&
                                    $_GET['category']==$sub->slug) selected @endif>
                                    &nbsp;&nbsp;— {{ $sub->title }}
                                </option>
                                @endforeach
                                @endif
                                @endforeach
                            </select>
                        </div>

                        <!--/ End Single Widget -->
                        <!-- Shop By Price -->
                        <div class="single-widget range">
                            <h3 class="title">Price</h3>
                            <div class="price-filter-inner">
                                @php
                                $price_ranges =
                                DB::table('price_ranges')->where('status','active')->orderBy('min_price','ASC')->get();
                                @endphp
                                <select name="price_range" class="form-control" onchange="this.form.submit()">
                                    <option value="">Select Price</option>
                                    @foreach($price_ranges as $range)
                                    <option value="{{ $range->slug }}" @if(!empty($_GET['price_range']) &&
                                        $_GET['price_range']==$range->slug) selected @endif>
                                        {{ $range->title }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="single-widget category">
                            <h3 class="title">Brands</h3>
                            @php
                            $brands = DB::table('brands')->orderBy('title','ASC')->where('status','active')->get();
                            @endphp
                            <select name="brand" class="form-control" onchange="this.form.submit()">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->slug }}" @if(!empty($_GET['brand']) &&
                                    $_GET['brand']==$brand->slug) selected @endif>
                                    {{ $brand->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12 col-md-8 col-12">
                    <div class="row">
                        <div class="col-12">
                        </div>
                    </div>
                    <div class="row">
                        {{-- {{$products}} --}}
                        @if(count($products)>0)
                        @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="single-product">
                                <div class="product-img">
                                    <a href="{{route('product-detail',$product->slug)}}">
                                        @php
                                        $photo=explode(',',$product->photo);
                                        @endphp
                                        <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                        <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                        @if($product->discount)
                                        <span class="price-dec">{{$product->discount}} % Off</span>
                                        @endif
                                    </a>
                                    <div class="button-head">
                                        <div class="product-action">
                                            <a data-toggle="modal" data-target="#{{$product->id}}" title="Quick View"
                                                href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                            <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}"
                                                class="wishlist" data-id="{{$product->id}}"><i
                                                    class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                        </div>
                                        <div class="product-action-2">
                                            <a title="Add to cart" href="{{route('add-to-cart',$product->slug)}}">Add to
                                                cart</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-content">
                                    <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a>
                                    </h3>
                                    @php
                                    $after_discount=($product->price-($product->price*$product->discount)/100);
                                    @endphp
                                    <span>₹{{number_format($after_discount,2)}}</span>
                                    <!-- <del style="padding-left:4%;">₹{{number_format($product->price,2)}}</del> -->
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <h4 class="text-warning" style="margin:100px auto;">There are no products.</h4>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12 justify-content-center d-flex">
                            {{$products->appends($_GET)->links()}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</form>


@endsection
@push('styles')
<style>
    .pagination {
        display: inline-flex;
    }

    .filter_button {
        /* height:20px; */
        text-align: center;
        background: #F7941D;
        padding: 8px 16px;
        margin-top: 10px;
        color: white;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt($("#slider-range").data('max')) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value + '-' + max_value;
            if ($("#price_range").length > 0 && $("#price_range").val()) {
                price_range = $("#price_range").val().trim();
            }

            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function(event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  " + currency + ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
        }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  " + m_currency + $("#slider-range").slider("values", 1));
        }
    })
</script>
@endpush