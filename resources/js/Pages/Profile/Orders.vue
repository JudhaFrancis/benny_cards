<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    orders: Array,
});

const formatDate = (dateString) => {
    if (!dateString) return "N/A";
    const options = { year: "numeric", month: "long", day: "numeric" };
    return new Date(dateString).toLocaleDateString(undefined, options);
};

const getStatusColor = (status) => {
    const colors = {
        pending: "bg-yellow-100 text-yellow-800",
        active: "bg-blue-100 text-blue-800",
        completed: "bg-green-100 text-green-800",
        cancelled: "bg-red-100 text-red-800",
        returned: "bg-purple-100 text-purple-800",
    };
    return colors[status] || "bg-gray-100 text-gray-800";
};

const formatPrice = (price) => {
    return new Intl.NumberFormat("en-IN", {
        style: "currency",
        currency: "INR",
        minimumFractionDigits: 2,
    }).format(price);
};
</script>

<template>
    <Head title="My Orders" />

    <AuthenticatedLayout>
        <!-- Compact Hero Section (Synced with Product Design) -->
        <div class="relative bg-gray-900 py-12 md:py-16 overflow-hidden">
            <!-- Decorative Background Elements -->
            <div class="absolute inset-0 z-0">
                <div
                    class="absolute top-0 -left-4 w-48 h-48 bg-primary/20 rounded-full blur-3xl opacity-20 animate-blob"
                ></div>
                <div
                    class="absolute bottom-0 -right-4 w-48 h-48 bg-blue-500/20 rounded-full blur-3xl opacity-20 animate-blob animation-delay-2000"
                ></div>
            </div>

            <div
                class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white"
            >
                <!-- Breadcrumbs -->
                <nav
                    class="flex justify-center mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gray-500"
                    aria-label="Breadcrumb"
                >
                    <ol class="flex items-center space-x-2">
                        <li>
                            <Link
                                :href="route('home')"
                                class="hover:text-primary transition-colors"
                                >Home</Link
                            >
                        </li>
                        <li>
                            <div class="flex items-center space-x-2">
                                <svg
                                    class="w-2.5 h-2.5 text-gray-700"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="3"
                                        d="M9 5l7 7-7 7"
                                    />
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
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100"
                >
                    <div class="p-6 text-gray-900">
                        <div
                            v-if="orders.length === 0"
                            class="text-center py-10"
                        >
                            <svg
                                class="mx-auto h-12 w-12 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">
                                No orders
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                You haven't placed any orders yet.
                            </p>
                            <div class="mt-6">
                                <Link
                                    href="/"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                >
                                    Start Shopping
                                </Link>
                            </div>
                        </div>

                        <div v-else class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Order ID
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Date
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Items
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Total
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Status
                                        </th>
                                        <th
                                            scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        >
                                            Payment
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white divide-y divide-gray-200"
                                >
                                    <tr
                                        v-for="order in orders"
                                        :key="order.id"
                                        class="hover:bg-gray-50 transition-colors"
                                    >
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-b-0"
                                        >
                                            #{{ order.order_number }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b-0"
                                        >
                                            {{ formatDate(order.order_date) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b-0"
                                        >
                                            {{ order.items_count }} (Qty:
                                            {{ order.total_quantity }})
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 border-b-0"
                                        >
                                            {{ formatPrice(order.total_amount) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm border-b-0"
                                        >
                                            <span
                                                :class="
                                                    getStatusColor(order.status)
                                                "
                                                class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize"
                                            >
                                                {{ order.status }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm border-b-0"
                                        >
                                            <span
                                                :class="{
                                                    'text-green-600':
                                                        order.payment_status ===
                                                        'paid',
                                                    'text-yellow-600':
                                                        order.payment_status ===
                                                        'due',
                                                    'text-red-600':
                                                        order.payment_status ===
                                                        'unpaid',
                                                }"
                                                class="font-semibold capitalize"
                                            >
                                                {{ order.payment_status }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
