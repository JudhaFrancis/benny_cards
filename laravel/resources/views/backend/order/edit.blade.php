@extends('backend.layouts.master')

@section('title', 'Edit Order')

@section('main-content')

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="order-header">Edit Order</h4>
            <span class="order-label">#{{ $order->order_number }}</span>
        </div>

    </div>

    <form id="editOrderForm" action="{{ route('order.update', $order->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="row g-4">

            <!-- LEFT COLUMN -->
            <div class="col-lg-8">

                <!-- ORDER INFORMATION -->
                <div class="order-section">
                    <h6 class="order-title">Order Information</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="order-label">Tracking ID</label>
                            <input type="text" name="tracking_id" class="form-control order-input"
                                value="{{ $order->tracking_id }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="order-label">Payment Status</label>
                            <select name="payment_status" class="form-select order-input">
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid
                                </option>
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="order-label">Order Status</label>
                            <select name="status" class="form-select order-input">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="active" {{ $order->status == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="returned" {{ $order->status == 'returned' ? 'selected' : '' }}>Returned
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="order-label">Order Date</label>
                            <input type="date" name="order_date" class="form-control order-input"
                                value="{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <!-- ORDER ITEMS -->
                <div class="order-section">
                    <h6 class="order-title">Order Items</h6>
                    @foreach ($order->items()->active()->get() as $item)
                    <div class="order-item">
                        <div class="d-flex align-items-center flex-grow-1">
                            <img src="{{ !empty($item->product->photo) ? asset($item->product->photo) : asset('backend/img/placeholder.png') }}"
                                alt="{{ $item->product->title }}">
                            <div>
                                <div class="order-item-title">{{ $item->product->title ?? 'Unknown Product' }}</div>
                            </div>
                        </div>
                        <div class="order-item-details text-end">
                            <input type="number" name="items[{{ $item->id }}][quantity]" class="form-control quantity"
                                value="{{ $item->quantity }}">
                            <input type="text" name="items[{{ $item->id }}][final_amount]" class="form-control price"
                                value="{{ $item->final_amount }}">
                            <input type="text" class="form-control total"
                                value="{{ $item->final_amount * $item->quantity }}" readonly>

                            <!-- DELETE FORM OUTSIDE MAIN FORM -->

                            <button type="button" class="btn btn-link text-danger p-0 delete-item"
                                data-id="{{ $item->id }}">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </div>

                    </div>
                    @endforeach
                    <!-- ADD NEW ITEM SECTION -->
                    <div class="order-section add-item-box mt-5 mb-5">
                        <h6 class="order-title mb-3">Add New Item</h6>

                        <div class="row align-items-end g-3">
                            <!-- Search Product -->
                            <div class="col-md-6">
                                <label class="order-label">Search Product</label>
                                <div class="search-wrapper">
                                    <div class="search-box">
                                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                                        <input type="text" class="form-control add-modern-input ps-4"
                                            placeholder="Search by product name or SKU...">
                                    </div>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div class="col-md-2">
                                <label class="order-label">Quantity</label>
                                <input type="number" class="form-control text-center add-modern-input" value="1"
                                    min="1">
                            </div>

                            <!-- Price -->
                            <div class="col-md-2">
                                <label class="order-label">Price</label>
                                <input type="text" class="form-control text-end add-modern-input">
                            </div>

                            <!-- Add Button -->
                            <div class="col-md-2 d-flex">
                                <button type="button"
                                    class="btn btn-add-item-modern w-100 d-flex align-items-center justify-content-center gap-2">
                                    <i class="fa-solid fa-cart-plus"></i>
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- DELETE CONFIRMATION MODAL -->
                    <div id="deleteModal" class="modal"
                        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:2000;">
                        <div
                            style="background:#fff; padding:20px; border-radius:10px; min-width:300px; max-width:400px; text-align:center; position:relative;">
                            <h5 style="margin-bottom:15px;">Are you sure you want to delete this item?</h5>
                            <div style="display:flex; justify-content:center; gap:15px;">
                                <button id="confirmDeleteBtn" class="btn btn-danger">Delete</button>
                                <button id="cancelDeleteBtn" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>


                    <!-- CLEAN TOTAL SECTION (no box) -->
                    <div class="order-totals-wrapper mt-4 pt-3">
                        <hr class="order-divider">
                        <div class="order-totals">
                            <div class="d-flex justify-content-end">
                                <div class="text-end">
                                    <div class="d-flex justify-content-between mb-2 gap-5">
                                        <span class="totals-label">Subtotal</span>
                                        <span id="subtotal" class="totals-value">$0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 gap-5">
                                        <span class="totals-label">Shipping</span>
                                        <span class="totals-value">${{ number_format($order->shipping, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3 gap-5">
                                        <span class="totals-label">Taxes</span>
                                        <span class="totals-value">${{ number_format($order->tax, 2) }}</span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center mt-3 gap-5">
                                        <span class="totals-total-label">Order Total</span>
                                        <span id="total" class="totals-total-value">$0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END TOTAL SECTION -->
                </div>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="col-lg-4">

                <!-- CUSTOMER DETAILS -->
                <div class="order-section">
                    <h6 class="order-title">Customer Details</h6>
                    <div class="mb-2">
                        <label class="order-label">Name</label>
                        <input type="text" name="name" class="form-control order-input" value="{{ $order->name }}">
                    </div>
                    <div class="mb-2">
                        <label class="order-label">Email</label>
                        <input type="email" name="email" class="form-control order-input" value="{{ $order->email }}">
                    </div>
                    <div class="mb-2">
                        <label class="order-label">Phone</label>
                        <input type="text" name="phone" class="form-control order-input" value="{{ $order->phone }}">
                    </div>
                </div>

                <!-- SHIPPING ADDRESS -->
                <div class="order-section">
                    <h6 class="order-title">Shipping Address</h6>
                    <div class="mb-2">
                        <label class="order-label">Address Line 1</label>
                        <input type="text" name="address_1" class="form-control order-input"
                            value="{{ $order->address_1 }}">
                    </div>
                    <div class="mb-2">
                        <label class="order-label">Address Line 2</label>
                        <input type="text" name="address_2" class="form-control order-input"
                            value="{{ $order->address_2 }}">
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label class="order-label">Country</label>
                            <input type="text" name="country" class="form-control order-input"
                                value="{{ $order->country }}">
                        </div>
                        <div class="col-md-6">
                            <label class="order-label">Postal Code</label>
                            <input type="text" name="post_code" class="form-control order-input"
                                value="{{ $order->post_code }}">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="order-label">Remarks</label>
                        <textarea name="remarks" class="form-control order-input"
                            rows="2">{{ $order->remarks }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary px-3">
                <i class="fa-solid fa-rotate" style="margin-right:10px;"></i>Update Order
            </button>
        </div>


    </form>
</div>

<style>
/* === ADD NEW ITEM BOX === */
.add-item-box {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
}

.add-modern-input {
    background-color: #f8f9fa;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 14px;
    color: #111827;
    height: 36px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.add-modern-input:focus {
    background-color: #fff;
    border-color: #6366f1;
    box-shadow: 0 0 0 0.1rem rgba(99, 102, 241, 0.25);
    outline: none;
}

/* === Search Box Icon Styling === */
.search-wrapper {
    position: relative;
}

.search-box {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 14px;
}

/* Add left padding to input with icon */
.search-box .form-control {
    padding-left: 32px;
}

/* === Add Button Modern === */
.btn-add-item-modern {
    background-color: #0ea5e9;
    border: none;
    color: #fff;
    font-weight: 600;
    font-size: 14px;
    border-radius: 6px;
    height: 36px;
    transition: background-color 0.2s ease, box-shadow 0.2s ease;
}

.btn-add-item-modern i {
    margin-right: 7px;
    font-size: 14px;
}


.btn-add-item-modern:focus {
    box-shadow: 0 0 0 0.15rem rgba(14, 165, 233, 0.35);
    outline: none;
}

.order-section .row .col-md-3 .order-input {
    width: 100%;
}

.order-section .row {
    display: flex;
}

.order-section .row>div {
    flex: 1;
}

.order-header {
    font-weight: 800;
    font-size: 21px;
    color: #111827;
    margin-bottom: 0.25rem;
}

.search-bar {
    width: 260px;
    font-size: 14px;
    border-radius: 6px;
    border: 1px solid #d1d5db;
    padding: 6px 12px;
}

.order-section {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
}

.order-title {
    font-weight: 700;
    font-size: 17px;
    color: #111827;
    margin-bottom: 15px;
}

.order-label {
    font-size: 14px;
    font-weight: 600;
    color: #8c8c8c;
    display: block;
    margin-bottom: 4px;
}

.order-input {
    background-color: #f8f9fa;
    font-size: 14px;
    border-radius: 6px;
    border: 1px solid #d1d5db;
    color: #111827;
    padding: 6px 12px;
}

.order-input:focus {
    border-color: #6366f1;
    background-color: #ffffff;
    box-shadow: 0 0 0 0.1rem rgba(99, 102, 241, 0.25);
}

.order-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid #f3f4f6;
}

.order-item img {
    width: 65px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
    margin-right: 12px;
}

.order-item-details {
    display: grid;
    grid-template-columns: 80px 100px 100px 40px;
    gap: 15px;
    text-align: right;
    align-items: center;
}

.order-item-title {
    font-size: 16px;
    color: #111827;
    font-weight: 600;
    max-width: 200px;
    word-wrap: break-word;
}

.order-divider {
    border: none;
    border-top: 1px solid #e5e7eb;
    margin-top: 10px;
    margin-bottom: 10px;
}

.order-totals-wrapper {
    display: flex;
    justify-content: flex-end;
}

.totals-label {
    color: #6b7280;
    font-size: 14px;
    font-weight: 500;
}

.totals-value {
    color: #111827;
    font-weight: 600;
    font-size: 14px;
}

.totals-total-label {
    font-weight: 700;
    font-size: 16px;
    color: #111827;
    display: inline-block;
    min-width: 220px;
}

.totals-total-value {
    font-weight: 800;
    font-size: 18px;
    color: #111827;
    margin-left: 20px;
}
</style>

<script>
document.querySelectorAll('.quantity, .price').forEach(function(input) {
    input.addEventListener('input', function() {
        let card = this.closest('.order-item');
        let qty = parseFloat(card.querySelector('.quantity').value) || 0;
        let price = parseFloat(card.querySelector('.price').value) || 0;
        card.querySelector('.total').value = (qty * price).toFixed(2);
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    function updateTotals() {
        let subtotal = 0;

        // Loop through all items and calculate totals
        document.querySelectorAll('.order-item').forEach(item => {
            const qty = parseFloat(item.querySelector('.quantity').value) || 0;
            const price = parseFloat(item.querySelector('.price').value) || 0;
            const total = qty * price;

            // Update total field
            item.querySelector('.total').value = total.toFixed(2);

            // Add to subtotal
            subtotal += total;
        });

        // Get shipping and tax values from Blade variables
        const shipping = parseFloat("{{ $order->shipping ?? 0 }}");
        const tax = parseFloat("{{ $order->tax ?? 0 }}");

        // Final total
        const totalAmount = subtotal + shipping + tax;

        // Update subtotal and total
        document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('total').textContent = '$' + totalAmount.toFixed(2);
    }

    document.querySelectorAll('.quantity, .price').forEach(input => {
        input.addEventListener('input', updateTotals);
    });

    // Run once on load
    updateTotals();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector(
        '.add-modern-input[placeholder="Search by product name or SKU..."]'
    );
    const quantityInput = document.querySelector('.add-modern-input[type="number"]');
    const priceInput = document.querySelector('.add-modern-input.text-end');
    const searchWrapper = document.querySelector('.search-wrapper');
    let unitPrice = 0; // store selected product price

    // Dropdown container
    const dropdown = document.createElement('div');
    dropdown.classList.add('dropdown-results');
    dropdown.style.position = 'absolute';
    dropdown.style.background = '#fff';
    dropdown.style.border = '1px solid #ddd';
    dropdown.style.width = '100%';
    dropdown.style.zIndex = '1000';
    dropdown.style.maxHeight = '200px';
    dropdown.style.overflowY = 'auto';
    dropdown.style.borderRadius = '6px';
    searchWrapper.appendChild(dropdown);

    // Search products
    searchInput.addEventListener('keyup', function() {
        const query = this.value.trim();
        if (query.length < 2) {
            dropdown.innerHTML = '';
            return;
        }

        fetch(`/admin/products/search?query=${query}`)
            .then(res => res.json())
            .then(data => {
                dropdown.innerHTML = '';
                if (data.length === 0) {
                    dropdown.innerHTML = '<div class="p-2 text-muted">No products found</div>';
                    return;
                }

                data.forEach(product => {
                    const item = document.createElement('div');
                    item.classList.add('dropdown-item', 'p-2');
                    item.style.cursor = 'pointer';
                    item.innerHTML = `<strong>${product.title}</strong>`;

                    item.addEventListener('click', function() {
                        searchInput.value = product.title;
                        searchInput.dataset.id = product.id;
                        unitPrice = parseFloat(product.price); // save unit price
                        priceInput.value = (unitPrice * (parseInt(quantityInput
                            .value) || 1)).toFixed(2);
                        dropdown.innerHTML = '';
                    });

                    dropdown.appendChild(item);
                });
            })
            .catch(err => console.error('Search error:', err));
    });

    // Quantity change updates price
    quantityInput.addEventListener('input', function() {
        const qty = parseInt(quantityInput.value) || 1;
        priceInput.value = (unitPrice * qty).toFixed(2);
    });
});
</script>
<!-- Add item button -->
<script>
document.querySelector('.btn-add-item-modern').addEventListener('click', function() {
    const productId = document.querySelector(
        '.add-modern-input[placeholder="Search by product name or SKU..."]').dataset.id;
    const quantity = parseInt(document.querySelector('.add-modern-input[type="number"]').value);
    const price = parseFloat(document.querySelector('.add-modern-input.text-end').value);
    const orderId = "{{ $order->id }}";

    fetch('{{ route("order.item.add") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                orders_id: orderId,
                product_id: productId,
                quantity: quantity,
            })
        })

        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // alert(data.success);
                location.reload(); //reload page to show new item
            }
        })
        .catch(err => console.error(err));
});
</script>

<!-- Delete Button -->
<script>
let deleteItemId = null; // store item id to delete

const deleteModal = document.getElementById('deleteModal');
const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

// Trash icon click
document.querySelectorAll('.delete-item').forEach(button => {
    button.addEventListener('click', function() {
        deleteItemId = this.dataset.id;
        deleteModal.style.display = 'flex'; // show modal
    });
});

// Cancel button
cancelDeleteBtn.addEventListener('click', () => {
    deleteItemId = null;
    deleteModal.style.display = 'none';
});

// Confirm Delete
confirmDeleteBtn.addEventListener('click', () => {
    if (!deleteItemId) return;

    fetch('{{ route("order.item.delete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: deleteItemId
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Remove item row from DOM
                const row = document.querySelector(`.delete-item[data-id='${deleteItemId}']`).closest(
                    '.order-item');
                row.remove();

                // Recalculate totals
                updateTotals();

                // Close modal
                deleteModal.style.display = 'none';
                deleteItemId = null;
            } else {
                alert(data.error || 'Something went wrong');
            }
        })
        .catch(err => console.error(err));
});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@endsection