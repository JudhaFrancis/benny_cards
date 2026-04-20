<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";

const props = defineProps({
    orders: Array,
});

const selectedOrder = ref(null);
const isModalOpen = ref(false);

const openOrderModal = (order) => {
    selectedOrder.value = order;
    isModalOpen.value = true;
};

const closeOrderModal = () => {
    isModalOpen.value = false;
    setTimeout(() => {
        selectedOrder.value = null;
    }, 300); // clear after animation
};

const formatDate = (dateString) => {
    if (!dateString) return "N/A";
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const getStatusColor = (status) => {
    if (!status) return "bg-gray-100 text-gray-800 border-gray-200";
    const s = status.toLowerCase();
    
    // Processing Group
    if (['active', 'processing', 'designed', 'designing process', 'printing in progress', 'printed', 'printing process', 'packing in progress', 'packed', 'packaging process'].includes(s)) {
        return "bg-blue-100 text-blue-800 border-blue-200";
    }
    
    // Shipped Group
    if (['shipped', 'dispatched', 'out for delivery'].includes(s)) {
        return "bg-indigo-100 text-indigo-800 border-indigo-200";
    }
    
    // Completed/Delivered Group
    if (['completed', 'delivered'].includes(s)) {
        return "bg-green-100 text-green-800 border-green-200";
    }
    
    // Others
    const colors = {
        pending: "bg-yellow-100 text-yellow-800 border-yellow-200",
        confirmed: "bg-yellow-100 text-yellow-800 border-yellow-200",
        cancelled: "bg-red-100 text-red-800 border-red-200",
        returned: "bg-purple-100 text-purple-800 border-purple-200",
    };
    return colors[s] || "bg-gray-100 text-gray-800 border-gray-200";
};

const formatPrice = (price) => {
    return new Intl.NumberFormat("en-IN", {
        style: "currency",
        currency: "INR",
        minimumFractionDigits: 2,
    }).format(price);
};

const formatDisplayStatus = (status) => {
    if (!status) return "Unknown";
    const s = status.toLowerCase();
    
    if (['active', 'processing', 'designed', 'designing process', 'printing in progress', 'printed', 'printing process', 'packing in progress', 'packed', 'packaging process'].includes(s)) {
        return "Processing";
    }
    if (['shipped', 'dispatched'].includes(s)) {
        return "Shipped";
    }
    if (s === 'out for delivery' || s === 'out_for_delivery') {
        return "Out for Delivery";
    }
    if (s === 'delivered') {
        return "Delivered";
    }
    
    // Capitalize first letter for others (pending, confirmed, completed, etc)
    return status.charAt(0).toUpperCase() + status.slice(1).toLowerCase();
};

const getOrderImage = (order) => {
    const items = order.order_items || order.orderItems || [];
    if (items.length > 0) {
        const item = items[0];
        if (item.product && item.product.photo) {
            const photos = item.product.photo.split(',');
            let photoPath = photos[0].trim();
            if (!photoPath.startsWith('/') && !photoPath.startsWith('http') && !photoPath.startsWith('data:')) {
                photoPath = '/storage/' + photoPath;
            }
            return photoPath;
        }
    }
    return '/images/placeholder.jpg';
};

const getItemImage = (item) => {
    if (item.product && item.product.photo) {
        const photos = item.product.photo.split(',');
        let photoPath = photos[0].trim();
        if (!photoPath.startsWith('/') && !photoPath.startsWith('http') && !photoPath.startsWith('data:')) {
            photoPath = '/storage/' + photoPath;
        }
        return photoPath;
    }
    return '/images/placeholder.jpg';
};

const getCustomer = (order) => {
    return order.customer_detail || order.customerDetail || null;
};
</script>

<template>
    <Head title="My Orders" />

    <AuthenticatedLayout>
        <!-- Compact Hero Section -->
        <div class="relative bg-gray-900 py-12 md:py-16 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <div class="absolute top-0 -left-4 w-48 h-48 bg-primary/20 rounded-full blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute bottom-0 -right-4 w-48 h-48 bg-blue-500/20 rounded-full blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            </div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
                <nav class="flex justify-center mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gray-500" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2">
                        <li>
                            <Link :href="route('home')" class="hover:text-primary transition-colors">Home</Link>
                        </li>
                        <li>
                            <div class="flex items-center space-x-2">
                                <svg class="w-2.5 h-2.5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                                </svg>
                                <span class="text-gray-400">My Orders</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-2xl md:text-3xl font-black text-white px-4">
                    My Orders
                </h1>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div v-if="orders.length === 0" class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 p-6 text-center py-10">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No orders</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't placed any orders yet.</p>
                    <div class="mt-6">
                        <Link href="/" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                            Start Shopping
                        </Link>
                    </div>
                </div>

                <!-- Cards Grid Layout -->
                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div 
                        v-for="order in orders" 
                        :key="order.id"
                        @click="openOrderModal(order)"
                        class="group relative bg-white border border-gray-100 rounded-3xl shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden flex flex-col"
                    >
                        <!-- Card Image Header -->
                        <div class="relative w-full aspect-square bg-gray-50 overflow-hidden">
                            <!-- Gradient overlay for text readability -->
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-gray-900/20 to-transparent z-10 transition-opacity duration-300 group-hover:from-gray-900/80"></div>
                            
                            <img 
                                :src="getOrderImage(order)" 
                                alt="Order Item" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out"
                            />
                            
                            <!-- Status Badge overlaid on top right -->
                            <div class="absolute top-5 right-5 z-20">
                                <span 
                                    :class="getStatusColor(order.status)" 
                                    class="px-4 py-1.5 inline-flex text-xs font-black rounded-full border shadow-lg backdrop-blur-md bg-opacity-95 uppercase tracking-wider"
                                >
                                    {{ formatDisplayStatus(order.status) }}
                                </span>
                            </div>
                            
                            <!-- Order ID overlaid beautifully on the bottom of the image -->
                            <div class="absolute bottom-0 left-0 right-0 p-6 z-20 transform group-hover:-translate-y-2 transition-transform duration-300">
                                <p class="text-white/80 text-[10px] font-bold uppercase tracking-[0.2em] mb-1.5 shadow-sm">Order ID</p>
                                <h3 class="text-white text-2xl font-black tracking-tight drop-shadow-md">{{ order.order_number }}</h3>
                            </div>
                        </div>
                        
                        <!-- Card Body (Clean & Minimal Date Section) -->
                        <div class="p-4 bg-white flex items-center justify-between border-t border-gray-50">
                            <div class="flex items-center text-xs font-bold text-gray-600 bg-gray-50/80 px-4 py-2.5 rounded-2xl group-hover:bg-primary/5 transition-colors">
                                <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ formatDate(order.order_date) }}
                            </div>
                            
                            <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Details Modal -->
                <transition 
                    enter-active-class="transition ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="transition ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <!-- Modal Container -->
                    <div v-if="isModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6" role="dialog" aria-modal="true">
                        
                        <!-- Backdrop -->
                        <div class="fixed inset-0 bg-gray-900/60 transition-opacity" @click="closeOrderModal"></div>

                        <!-- Modal Panel -->
                        <transition
                            enter-active-class="transition ease-out duration-300 transform"
                            enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                            leave-active-class="transition ease-in duration-200 transform"
                            leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                            leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        >
                            <div v-if="selectedOrder" class="relative bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto flex flex-col items-start text-left z-10 transition-all">
                                
                                <!-- Sticky Header -->
                                <div class="sticky top-0 z-20 w-full bg-white px-6 py-4 flex justify-between items-center rounded-t-2xl shadow-sm border-b border-gray-100">
                                    <h2 class="text-lg font-semibold flex items-center gap-2 text-gray-800">
                                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        Order Details
                                    </h2>
                                    <button @click="closeOrderModal" class="text-gray-400 hover:text-gray-600 border border-gray-200 hover:bg-gray-50 p-1.5 rounded-full transition-colors flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>

                                <!-- Scrollable Body -->
                                <div class="w-full p-6 sm:p-8 flex flex-col gap-8">
                                    
                                    <!-- 4 Column Header Info -->
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 bg-white shrink-0">
                                        <div>
                                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                                <span class="text-gray-300">#</span> Order ID
                                            </p>
                                            <p class="text-sm font-semibold text-gray-900">{{ selectedOrder.order_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                Order Date
                                            </p>
                                            <p class="text-sm font-semibold text-gray-900">{{ formatDate(selectedOrder.order_date) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                                Payment
                                            </p>
                                            <p class="text-sm font-semibold uppercase" :class="{'text-green-600': selectedOrder.payment_status === 'paid', 'text-yellow-600': selectedOrder.payment_status === 'due', 'text-red-600': selectedOrder.payment_status === 'unpaid'}">
                                                {{ selectedOrder.payment_status }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                Status
                                            </p>
                                            <p class="text-sm font-semibold capitalize" :class="{'text-green-600': selectedOrder.status === 'completed', 'text-gray-900': selectedOrder.status !== 'completed'}">
                                                {{ formatDisplayStatus(selectedOrder.status) }}
                                            </p>
                                        </div>
                                    </div>

                                    <hr class="border-gray-100" />

                                    <!-- Order Progress Timeline -->
                                    <div>
                                        <h3 class="text-base font-bold flex items-center gap-2 mb-6 text-gray-800">
                                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-.59-1.41l-2.83-2.83A2 2 0 0016.17 6H14v10a2 2 0 002 2z"></path><circle cx="8" cy="18" r="2"></circle><circle cx="16" cy="18" r="2"></circle></svg>
                                            Order Progress
                                        </h3>
                                        <div class="relative pl-3 space-y-6">
                                            <!-- Timeline Line -->
                                            <div class="absolute top-2 bottom-2 left-4 w-0.5 bg-gray-200 z-0"></div>

                                            <!-- Step 1: Confirmed -->
                                            <div class="relative z-10 flex gap-4">
                                                <div class="w-3 h-3 rounded-full bg-green-500 ring-[5px] ring-white mt-1"></div>
                                                <div>
                                                    <h4 class="text-base font-bold text-gray-900">Order Confirmed <span class="text-gray-400 font-normal text-xs ml-2">{{ formatDate(selectedOrder.order_date) }}</span></h4>
                                                    <p class="text-base text-gray-500 mt-0.5">Your order has been confirmed and will be processed soon.</p>
                                                </div>
                                            </div>

                                            <!-- Step 2: Processing -->
                                            <div class="relative z-10 flex gap-4">
                                                <div 
                                                    class="rounded-full ring-[5px] ring-white mt-1"
                                                    :class="['active', 'processing', 'designed', 'designing process', 'printing in progress', 'printed', 'printing process', 'packing in progress', 'packed', 'packaging process', 'shipped', 'dispatched', 'out for delivery', 'out_for_delivery', 'delivered', 'completed'].includes(selectedOrder.status?.toLowerCase()) ? 'bg-green-500 w-3 h-3' : 'bg-transparent border-[2px] border-gray-400 w-3 h-3 -ml-[1px]'"
                                                ></div>
                                                <div>
                                                    <h4 class="text-base font-bold" :class="['active', 'processing', 'designed', 'designing process', 'printing in progress', 'printed', 'printing process', 'packing in progress', 'packed', 'packaging process', 'shipped', 'dispatched', 'out for delivery', 'out_for_delivery', 'delivered', 'completed'].includes(selectedOrder.status?.toLowerCase()) ? 'text-gray-900' : 'text-gray-500'">Processing</h4>
                                                    <p class="text-base text-gray-500 mt-0.5">Your items are being prepared for shipment.</p>
                                                </div>
                                            </div>

                                            <!-- Step 3: Shipped -->
                                            <div class="relative z-10 flex gap-4">
                                                <div 
                                                    class="rounded-full ring-[5px] ring-white mt-1"
                                                    :class="['shipped', 'dispatched', 'out for delivery', 'out_for_delivery', 'delivered', 'completed'].includes(selectedOrder.status?.toLowerCase()) ? 'bg-green-500 w-3 h-3' : 'bg-transparent border-[2px] border-gray-400 w-3 h-3 -ml-[1px]'"
                                                ></div>
                                                <div>
                                                    <h4 class="text-base font-bold" :class="['shipped', 'dispatched', 'out for delivery', 'out_for_delivery', 'delivered', 'completed'].includes(selectedOrder.status?.toLowerCase()) ? 'text-gray-900' : 'text-gray-500'">Shipped</h4>
                                                    <p class="text-base text-gray-500 mt-0.5">Your package has been shipped and is on its way.</p>
                                                </div>
                                            </div>

                                            <!-- Step 4: Out for Delivery -->
                                            <div class="relative z-10 flex gap-4">
                                                <div 
                                                    class="rounded-full ring-[5px] ring-white mt-1"
                                                    :class="['out for delivery', 'out_for_delivery', 'delivered', 'completed'].includes(selectedOrder.status?.toLowerCase()) ? 'bg-green-500 w-3 h-3' : 'bg-transparent border-[2px] border-gray-400 w-3 h-3 -ml-[1px]'"
                                                ></div>
                                                <div>
                                                    <h4 class="text-base font-bold" :class="['out for delivery', 'out_for_delivery', 'delivered', 'completed'].includes(selectedOrder.status?.toLowerCase()) ? 'text-gray-900' : 'text-gray-500'">Out for Delivery</h4>
                                                    <p class="text-base text-gray-500 mt-0.5">Your package is out for delivery and will arrive today.</p>
                                                </div>
                                            </div>

                                            <!-- Step 5: Delivered -->
                                            <div class="relative z-10 flex gap-4">
                                                <div 
                                                    class="rounded-full ring-[5px] ring-white mt-1"
                                                    :class="['delivered', 'completed'].includes(selectedOrder.status?.toLowerCase()) ? 'bg-green-500 w-3 h-3' : 'bg-transparent border-[2px] border-gray-400 w-3 h-3 -ml-[1px]'"
                                                ></div>
                                                <div>
                                                    <h4 class="text-base font-bold" :class="['delivered', 'completed'].includes(selectedOrder.status?.toLowerCase()) ? 'text-gray-900' : 'text-gray-500'">Delivered</h4>
                                                    <p class="text-base text-gray-500 mt-0.5">Package delivered successfully.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="border-gray-100" />

                                    <!-- Order Items -->
                                    <div>
                                        <h3 class="text-base font-bold text-gray-800 mb-3">Order Items</h3>
                                        <div class="space-y-2.5">
                                            <div v-for="item in (selectedOrder.order_items || selectedOrder.orderItems)" :key="item.id" class="flex items-center gap-4 bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                                                <div class="w-14 h-14 bg-white rounded-lg shadow-sm flex items-center justify-center p-1 relative">
                                                    <img 
                                                        v-if="item.product && item.product.photo" 
                                                        :src="getItemImage(item)" 
                                                        alt="Product"
                                                        class="max-w-full max-h-full object-contain"
                                                    />
                                                    <svg v-else class="w-6 h-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                                <div class="flex-grow">
                                                    <h4 class="font-bold text-base text-gray-900 leading-tight">{{ item.product_name }}</h4>
                                                    <p class="text-base font-medium text-gray-500 mt-0.5">Qty: {{ item.quantity }}</p>
                                                </div>
                                                <div class="font-bold text-base text-gray-900">
                                                    {{ formatPrice(item.total_price) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="border-gray-100" />

                                    <!-- Delivery Address -->
                                    <div v-if="getCustomer(selectedOrder)">
                                        <h3 class="text-base font-bold flex items-center gap-2 mb-3 text-gray-800">
                                            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            Delivery Address
                                        </h3>
                                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                            <p class="font-bold text-base text-gray-900 mb-1">{{ getCustomer(selectedOrder).name }}</p>
                                            <p class="text-base text-gray-600 leading-snug">{{ getCustomer(selectedOrder).address_1 }}</p>
                                            <p v-if="getCustomer(selectedOrder).address_2 && getCustomer(selectedOrder).address_2 !== getCustomer(selectedOrder).address_1" class="text-base text-gray-600 mt-0.5 leading-snug">{{ getCustomer(selectedOrder).address_2 }}</p>
                                            <p class="text-base font-medium text-gray-800 mt-2 flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                {{ getCustomer(selectedOrder).phone }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Total Amount Block (Primary theme) -->
                                    <div class="bg-primary/5 py-3 px-5 rounded-xl flex justify-between items-center border border-primary/20">
                                        <p class="font-bold text-sm text-gray-800">Total Amount</p>
                                        <p class="font-black text-xl text-primary">{{ formatPrice(selectedOrder.total_amount) }}</p>
                                    </div>

                                </div>
                            </div>
                        </transition>
                    </div>
                </transition>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
