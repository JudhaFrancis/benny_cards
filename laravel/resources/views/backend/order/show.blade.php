@extends('backend.layouts.master')

@section('title','View Order')

@section('main-content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            Order Details #{{ $order->order_number }}
        </h6>
        <a href="{{ route('order.edit', $order->id) }}" class="btn btn-sm btn-primary">
            <i class="fas fa-edit"></i> Edit Order
        </a>
    </div>

    <div class="card-body">

        {{-- ===================== ORDER INFORMATION ===================== --}}
        <h5 class="mb-3"><strong>Order Information</strong></h5>
        <div class="row mb-3">
            <div class="col-md-3"><label><strong>Tracking ID:</strong></label> {{ $order->tracking_id ?? 'N/A' }}</div>
            <div class="col-md-3"><label><strong>Payment Status:</strong></label> {{ ucfirst($order->payment_status) }}
            </div>
            <div class="col-md-3"><label><strong>Order Status:</strong></label> {{ ucfirst($order->status) }}</div>
            <div class="col-md-3"><label><strong>Order Date:</strong></label>
                {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</div>
        </div>

        <hr>

        {{-- ===================== ORDER ITEMS ===================== --}}
        <h5 class="mb-3"><strong>Order Items</strong></h5>
        @foreach ($order->items as $key => $item)
        <div class="card mb-3 p-3">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    @if(!empty($item->product->photo))
                    <img src="{{ asset($item->product->photo) }}" alt="{{ $item->product->title }}"
                        class="img-fluid rounded shadow-sm" style="max-height: 80px; object-fit: cover;">
                    @else
                    <img src="{{ asset('backend/img/placeholder.png') }}" alt="No Image"
                        class="img-fluid rounded shadow-sm" style="max-height: 80px;">
                    @endif
                </div>

                <div class="col-md-3">
                    <label><strong>Product:</strong></label>
                    <div style="white-space: normal; word-wrap: break-word;">
                        {{ $item->product->title ?? 'Unknown Product' }}
                    </div>
                </div>

                <div class="col-md-2">
                    <label><strong>Quantity:</strong></label>
                    <div>{{ $item->quantity }}</div>
                </div>

                <div class="col-md-2">
                    <label><strong>Price:</strong></label>
                    <div>₹{{ number_format($item->final_amount, 2) }}</div>
                </div>

                <div class="col-md-2">
                    <label><strong>Total:</strong></label>
                    <div>₹{{ number_format($item->total_amount, 2) }}</div>
                </div>
            </div>
        </div>
        @endforeach

        <hr>

        {{-- ===================== CUSTOMER & SHIPPING DETAILS ===================== --}}
        <h5 class="mb-3"><strong>Customer Details</strong></h5>

        <div class="card p-3 mb-3" style="background-color:#f9f9f9;">
            <div class="row mb-3">
                <div class="col-md-4"><label><strong>Name:</strong></label> {{ $order->name }}</div>
                <div class="col-md-4"><label><strong>Email:</strong></label> {{ $order->email }}</div>
                <div class="col-md-4"><label><strong>Phone:</strong></label> {{ $order->phone }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6 mb-2">
                    <label class="text-muted d-block"><strong>Address Line 1</strong></label>
                    <span class="h6 text-dark">{{ $order->address_1 }}</span>
                </div>

                @if(!empty($order->address_2))
                <div class="col-md-6 mb-2">
                    <label class="text-muted d-block"><strong>Address Line 2</strong></label>
                    <span class="h6 text-dark">{{ $order->address_2 }}</span>
                </div>
                @endif
            </div>

            <div class="row mb-3">
                @if(!empty($order->country))
                <div class="col-md-4">
                    <label><strong>Country:</strong></label> {{ $order->country }}
                </div>
                @endif

                @if(!empty($order->post_code))
                <div class="col-md-4">
                    <label><strong>Postal Code:</strong></label> {{ $order->post_code }}
                </div>
                @endif
                @if(!empty($order->remarks))
                <div class="col-md-4">
                    <label><strong>Remarks:</strong></label> {{ $order->remarks }}
                </div>
                @endif
            </div>
        </div>

        <hr>

        {{-- ===================== AMOUNT SUMMARY ===================== --}}
        <h5 class="mb-3"><strong>Order Summary</strong></h5>
        <div class="card p-3" style="background-color:#f9f9f9;">
            <div class="row">
                <div class="col-md-12 text-end">
                    <h5 class="m-0">
                        <strong>Total Amount:</strong> ₹{{ number_format($order->net_amount, 2) }}
                    </h5>
                </div>
            </div>
        </div>
        @endsection