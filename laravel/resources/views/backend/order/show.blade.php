@extends('backend.layouts.master')

@section('title', 'View Order')

@section('main-content')

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="order-header">Order Details</h4>
            <span class="order-label">#{{ $order->order_number }}</span>
        </div>
        <a href="{{ route('order.edit', $order->id) }}" class="btn btn-primary edit-btn">
            <i class="fa-solid fa-pen"></i>
            <span>Edit Order</span>
        </a>
    </div>

    <div class="row g-4">

        <!-- LEFT COLUMN -->
        <div class="col-lg-8">

            <!-- ORDER INFO -->
            <div class="order-section">
                <h6 class="order-title">Order Information</h6>
                <div class="row">
                    <div class="col-md-3">
                        <span class="order-label">Tracking ID</span>
                        <span class="order-value">{{ $order->tracking_id ?? 'N/A' }}</span>
                    </div>
                    <div class="col-md-3">
                        <span class="order-label">Payment Status</span>
                        <span class="order-badge 
                            @if($order->payment_status=='paid') badge-paid 
                            @elseif($order->payment_status=='unpaid') badge-unpaid 
                            @else badge-pending @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div class="col-md-3">
                        <span class="order-label">Order Status</span>
                        <span class="order-badge 
                            @if($order->status=='pending') badge-pending 
                            @elseif($order->status=='completed') badge-paid 
                            @else badge-unpaid @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="col-md-3">
                        <span class="order-label">Order Date</span>
                        <span
                            class="order-value">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- ORDER ITEMS -->
            <div class="order-section">
                <h6 class="order-title">Order Items</h6>
                @php $subTotal = 0; @endphp
                @foreach ($order->items as $item)
                @php
                $itemTotal = $item->final_amount * $item->quantity;
                $subTotal += $itemTotal;
                @endphp
                <div class="order-item">
                    <div class="d-flex align-items-center flex-grow-1">
                        <img src="{{ !empty($item->product->photo) ? asset($item->product->photo) : asset('backend/img/placeholder.png') }}"
                            alt="{{ $item->product->title }}">
                        <div>
                            <div class="order-item-title">{{ $item->product->title ?? 'Unknown Product' }}</div>
                        </div>
                    </div>
                    <div class="order-item-details text-end">
                        <span class="item-qty">{{ $item->quantity }}</span>
                        <span class="item-price">₹{{ number_format($item->final_amount, 2) }}</span>
                        <span class="item-total" style="color:#333">₹{{ number_format($itemTotal, 2) }}</span>
                    </div>
                </div>
                @endforeach
            </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-4">

            <!-- CUSTOMER DETAILS -->
            <div class="order-section">
                <h6 class="order-title">Customer Details</h6>
                <div class="mb-2">
                    <span class="order-label">Name</span>
                    <span class="order-value">{{ $order->name }}</span>
                </div>
                <div class="mb-2">
                    <span class="order-label">Contact</span>
                    <div class="order-value">{{ $order->email }}<br>{{ $order->phone }}</div>
                </div>
                <div class="mb-2">
                    <span class="order-label">Shipping Address</span>
                    <div class="order-value">
                        {{ $order->address_1 }}
                        @if($order->address_2), {{ $order->address_2 }} @endif<br>
                        {{ $order->country ?? 'IND' }}, {{ $order->post_code }}
                    </div>
                </div>
                @if(!empty($order->remarks))
                <div class="mb-0">
                    <span class="order-label">Remarks</span>
                    <div class="order-value">{{ $order->remarks }}</div>
                </div>
                @endif
            </div>

            <!-- ORDER SUMMARY -->
            @php
            $tax = $order->tax ?? 7;
            $total = $subTotal + $tax;
            @endphp
            <div class="order-section order-summary">
                <h6 class="order-title">Order Summary</h6>
                <div class="d-flex justify-content-between mb-1">
                    <span>Amount</span>
                    <span>₹{{ number_format($order->total_amount ?? 0, 2) }}</span>
                </div>

                <div class="d-flex justify-content-between mb-1">
                    <span>Discount</span>
                    <span> ₹{{ number_format($order->discount ?? 0, 2) }}</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between order_total_amount">
                    <strong>Total Amount</strong>
                    <strong>₹{{ number_format($order->net_amount ?? 0, 2) }}</strong>
                </div>
            </div>

        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@endsection