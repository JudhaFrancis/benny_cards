@extends('backend.layouts.master')

@section('title','Edit Order')

@section('main-content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Order #{{ $order->order_number }}</h6>
    </div>

    <div class="card-body">
        <form action="{{ route('order.update', $order->id) }}" method="POST">
            @csrf
            @method('PATCH')

            {{-- ===================== ORDER INFORMATION ===================== --}}
            <h5 class="mb-3"><strong>Order Information</strong></h5>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label>Tracking ID</label>
                    <input type="text" name="tracking_id" class="form-control" value="{{ $order->tracking_id }}">
                </div>
                <div class="col-md-3">
                    <label>Payment Status</label>
                    <select name="payment_status" class="form-control">
                        <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="due" {{ $order->payment_status == 'due' ? 'selected' : '' }}>Due</option>
                        <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Order Status</label>
                    <select name="status" class="form-control">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ $order->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="returned" {{ $order->status == 'returned' ? 'selected' : '' }}>Returned</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Order Date</label>
                    <input type="date" name="order_date" class="form-control"
                        value="{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}">
                </div>
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
                        <label>Product</label>
                        <div class="form-control-plaintext"
                            style="white-space: normal; word-wrap: break-word; overflow-wrap: break-word; max-width: 100%;">
                            {{ $item->product->title ?? 'Unknown Product' }}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <label>Quantity</label>
                        <input type="number" name="items[{{ $item->id }}][quantity]" class="form-control quantity"
                            value="{{ $item->quantity }}">
                    </div>
                    <div class="col-md-2">
                        <label>Price</label>
                        <input type="text" name="items[{{ $item->id }}][final_amount]" class="form-control price"
                            value="{{ $item->final_amount }}">
                    </div>
                    <div class="col-md-2">
                        <label>Total</label>
                        <input type="text" class="form-control total" value="{{ $item->total_amount }}" readonly>
                    </div>
                </div>

            </div>
            @endforeach

            <hr>

            {{-- ===================== CUSTOMER DETAILS ===================== --}}
            <h5 class="mb-3"><strong>Customer Details</strong></h5>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $order->name }}">
                </div>
                <div class="col-md-4">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $order->email }}">
                </div>
                <div class="col-md-4">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $order->phone }}">
                </div>
            </div>

            {{-- ===================== SHIPPING ===================== --}}
            <h5 class="mb-3"><strong>Shipping Address</strong></h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Address Line 1</label>
                    <input type="text" name="address_1" class="form-control" value="{{ $order->address_1 }}">
                </div>
                <div class="col-md-6">
                    <label>Address Line 2</label>
                    <input type="text" name="address_2" class="form-control" value="{{ $order->address_2 }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Country</label>
                    <input type="text" name="country" class="form-control" value="{{ $order->country }}">
                </div>
                <div class="col-md-4">
                    <label>Postal Code</label>
                    <input type="text" name="post_code" class="form-control" value="{{ $order->post_code }}">
                </div>
                <div class="col-md-4">
                    <label>Remarks</label>
                    <textarea name="remarks" class="form-control">{{ $order->remarks }}</textarea>
                </div>
            </div>

            <hr>

            <button type="submit" class="btn btn-primary">Update Order</button>
        </form>
    </div>
</div>

<script>
// Auto calculate total when quantity or price changes
document.querySelectorAll('.quantity, .price').forEach(function(input) {
    input.addEventListener('input', function() {
        let card = this.closest('.card'); // find the card container
        let qty = parseFloat(card.querySelector('.quantity').value) || 0;
        let price = parseFloat(card.querySelector('.price').value) || 0;
        let totalField = card.querySelector('.total');
        totalField.value = (qty * price).toFixed(2);
    });
});
</script>
@endsection