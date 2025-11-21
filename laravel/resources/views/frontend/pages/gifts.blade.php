@extends('frontend.layouts.master')

@section('title','BENNY CARDS || Gifts')

@section('main-content')

<div class="breadcrumbs">
    <div class="section-container">
        <ul class="bread-list">
            <li><a href="{{ url('/') }}">Home <i class="ti-arrow-right"></i></a></li>
            <li class="active"><span>Gifts</span></li>
        </ul>
    </div>
</div>

<section class="product-area shop">
    <div class="section-container pt-4">
        <div class="row">
            @foreach($products as $product)
            @php
            $photo = explode(',', $product->photo);
            $after_discount = ($product->price - ($product->price * $product->discount) / 100);
            @endphp

            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="product-card-modern">
                    <div class="product-image-modern">
                        <a href="{{ route('product-detail', $product->slug) }}">
                            <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                        </a>
                    </div>

                    <div class="product-info-modern text-center">
                        <h3 class="product-title">
                            <a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                        </h3>

                        <div class="product-price d-flex justify-content-center align-items-center gap-2">
                            <span class="current-price fw-bold text-dark">
                                ₹{{ number_format($after_discount, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</section>

@endsection
@push('scripts')
<script>
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

