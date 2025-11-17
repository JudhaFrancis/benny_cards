@extends('frontend.layouts.master')

@section('title','BENNY CARDS || MY ORDERS')

@section('main-content')

<div class="section-container py-5">
    <h2 class="text-4xl font-semibold mb-2" style="color:#3cc0c2;">
        My Orders
    </h2>
    <p>
        Track and manage all your orders
    </p>

    @forelse($orders as $order)
    <div class="card my-4 p-4 shadow-sm border order-card">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            {{-- Left section with icon + order info --}}
            <div class="d-flex align-items-center" style="gap: 20px; align-items: center;">
                {{-- Package icon --}}
                <div class="package-icon-wrapper d-flex align-items-center justify-content-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"
                        stroke="#3cc0c2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-package">
                        <path d="M16.5 9.4 7.5 4.21"></path>
                        <path
                            d="m21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                        </path>
                        <path d="M3.3 7 12 12l8.7-5"></path>
                        <path d="M12 22V12"></path>
                    </svg>
                </div>


                {{-- Order details --}}
                <div>
                    <h6 class="font-mono font-semibold text-lg mb-1">
                        #{{ $order->order_number }}
                    </h6>

                    @php
                    $itemCount = \App\Models\OrderItems::where('orders_id', $order->id)->where('status', 1)->count();
                    @endphp
                    <small class="text-sm text-muted-foreground d-block mb-2">
                        {{ $itemCount }} {{ Str::plural('item', $itemCount) }}
                    </small>

                    <div class="d-flex align-items-center flex-wrap text-muted-foreground"
                        style="font-size: 0.9rem; column-gap: 1rem; row-gap: 0.4rem;">
                        <div class="d-flex align-items-center" style="gap: 5px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-calendar">
                                <path d="M8 2v4"></path>
                                <path d="M16 2v4"></path>
                                <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                <path d="M3 10h18"></path>
                            </svg>
                            <span>Ordered: {{ $order->created_at->format('d/m/Y') }}</span>
                        </div>

                        <div class="d-flex align-items-center" style="gap: 5px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor\" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-truck">
                                <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path>
                                <path d="M15 18H9"></path>
                                <path
                                    d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14">
                                </path>
                                <circle cx="17" cy="18" r="2"></circle>
                                <circle cx="7" cy="18" r="2"></circle>
                            </svg>
                            <span>{{ $order->tracking_id ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Status badge --}}
            @php
            $statusClass = '';
            switch(strtolower($order->status)) {
            case 'pending': $statusClass = 'badge-pending'; break;
            case 'active': $statusClass = 'badge-active'; break;
            case 'completed': $statusClass = 'badge-completed'; break;
            case 'returned': $statusClass = 'badge-returned'; break;
            case 'cancelled': $statusClass = 'badge-cancelled'; break;
            default: $statusClass = 'badge-secondary'; break;
            }
            @endphp

            <span class="badge {{ $statusClass }} mt-2 mt-md-0">
                {{ ucfirst($order->status) }}
            </span>

        </div>

        {{-- Price and link --}}
        <div class="position-relative">
            <!-- horizontal line -->
            <div class="custom-horizontal-line"></div>

            <div class="d-flex justify-content-between align-items-center pt-2">
                <div class="d-flex align-items-center" style="margin-left:80px;">
                    <span class="fs-5 mb-0 order_details_amount">
                        ₹{{ number_format($order->total_amount, 2) }}
                    </span>
                </div>

                <a href="{{ route('order.track', $order->id) }}"
                    class="inline-flex items-center justify-center gap-2 px-3 py-2 rounded-md text-sm font-semibold text-dark transition hover:text-primary hover:bg-gray-100">
                    <span class="font-semibold text-base">View Details</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                        class="h-4 w-4 align-middle">
                        <path d="m9 18 6-6-6-6"></path>
                    </svg>
                </a>


            </div>
        </div>

    </div>
    @empty
    <p>No orders found.</p>
    @endforelse

</div>
<style>
.badge-pending {
    background-color: #fffdf0;
    color: #f57c00;
}

.badge-active {
    background-color: #e0f0ff;
    color: #0d6efd;
}

.badge-completed {
    background-color: #f0fff4;
    color: #2e7d32;
}

.badge-returned {
    background-color: #f3f0ff;
    color: #6f42c1;
}

.badge-cancelled {
    background-color: #fff0f0;
    color: #d32f2f;
}

/* common style for all badges */
.badge {
    padding: 6px 12px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 13px;
}

.package-icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background-color: #f3f8ff;
    box-shadow: 0 2px 6px rgba(60, 192, 194, 0.15);
    transition: all 0.3s ease;
    margin-top: 0;
}

.custom-horizontal-line {
    position: absolute;
    left: 80px;
    right: 0;
    top: 0;
    height: 1px;
    background-color: hsl(214 32% 88%);
    opacity: 0.8;
}


.custom-horizontal-line {
    top: -10px;
    /* move up */
}
</style>
@endsection