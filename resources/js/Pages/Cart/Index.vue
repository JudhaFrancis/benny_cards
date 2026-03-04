<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref, computed } from "vue";

const props = defineProps({
    cartItems: {
        type: Array,
        required: true,
    },
});

const subtotal = computed(() => {
    return props.cartItems.reduce((acc, item) => acc + parseFloat(item.amount || 0), 0);
});

const updateQuantity = (item, delta) => {
    const currentQty = parseInt(item.quantity) || 0;
    const newQuantity = currentQty + delta;
    if (newQuantity < 1) return;

    router.patch(
        route("cart.update", item.id),
        {
            quantity: newQuantity,
        },
        {
            preserveScroll: true,
        },
    );
};

const setAbsoluteQuantity = (item) => {
    // Ensure quantity is a valid number and at least 1
    let newQuantity = parseInt(item.quantity);
    if (isNaN(newQuantity) || newQuantity < 1) {
        newQuantity = 1;
        item.quantity = 1; // reset the input visually
    }

    router.patch(
        route("cart.update", item.id),
        {
            quantity: newQuantity,
        },
        {
            preserveScroll: true,
        },
    );
};

const removeItem = (id) => {
    router.delete(route("cart.destroy", id), {
        preserveScroll: true,
    });
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
    <Head title="My Cart" />

    <AuthenticatedLayout :transparent-header="false">
        <!-- Hero Section -->
        <div class="relative bg-gray-900 py-12 md:py-16 overflow-hidden">
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
                <nav
                    class="flex justify-center mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gray-500"
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
                                <span class="text-gray-400">My Cart</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl md:text-3xl font-black text-white px-4">
                    Shopping Cart
                </h1>
            </div>
        </div>

        <div class="py-20 md:py-24 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    v-if="cartItems.length > 0"
                    class="flex flex-col lg:flex-row gap-8"
                >
                    <!-- Cart Items -->
                    <div class="flex-1 space-y-4">
                        <div
                            v-for="item in cartItems"
                            :key="item.id"
                            class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm flex items-center gap-6"
                        >
                            <div
                                class="w-24 h-24 bg-gray-100 rounded-2xl overflow-hidden border border-gray-100 flex-shrink-0"
                            >
                                <img
                                    v-if="item.product.photo"
                                    :src="item.product.photo"
                                    :alt="item.product.title"
                                    class="w-full h-full object-cover"
                                />
                            </div>

                            <div class="flex-1 min-w-0">
                                <Link
                                    :href="
                                        route('product.show', item.product.slug)
                                    "
                                    class="text-lg font-black text-gray-900 hover:text-primary transition-colors block truncate"
                                >
                                    {{ item.product.title }}
                                </Link>
                                <p class="text-sm font-bold text-primary mt-1">
                                    {{ formatPrice(item.price) }}
                                </p>
                            </div>

                            <div class="flex items-center gap-4">
                                <div
                                    class="flex items-center bg-gray-50 rounded-xl p-1 border border-gray-100"
                                >
                                    <button
                                        @click="updateQuantity(item, -1)"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white hover:shadow-sm transition-all text-gray-500"
                                    >
                                        -
                                    </button>
                                    <input
                                        type="number"
                                        v-model.number="item.quantity"
                                        @blur="setAbsoluteQuantity(item)"
                                        @keyup.enter="setAbsoluteQuantity(item)"
                                        min="1"
                                        class="w-12 text-center font-black text-sm bg-transparent border-none p-0 focus:ring-0 appearance-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none"
                                    />
                                    <button
                                        @click="updateQuantity(item, 1)"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white hover:shadow-sm transition-all text-gray-500"
                                    >
                                        +
                                    </button>
                                </div>
                                <button
                                    @click="removeItem(item.id)"
                                    class="p-2 text-gray-400 hover:text-red-500 transition-colors"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="w-full lg:w-96">
                        <div
                            class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-xl shadow-gray-200/50 sticky top-24"
                        >
                            <h2
                                class="text-xl font-black text-gray-900 mb-6 uppercase tracking-tight"
                            >
                                Order Summary
                            </h2>
                            <div class="space-y-4 mb-8">
                                <div
                                    class="flex justify-between text-gray-500 font-bold uppercase text-[10px] tracking-widest"
                                >
                                    <span>Subtotal</span>
                                    <span>{{ formatPrice(subtotal) }}</span>
                                </div>
                                <div
                                    class="pt-4 border-t border-gray-100 flex justify-between items-center"
                                >
                                    <span
                                        class="text-lg font-black text-gray-900"
                                        >Total</span
                                    >
                                    <span
                                        class="text-2xl font-black text-primary"
                                        >{{ formatPrice(subtotal) }}</span
                                    >
                                </div>
                            </div>
                            <Link
                                :href="route('checkout.index')"
                                class="w-full flex justify-center bg-primary text-white font-black py-4 rounded-2xl shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all hover:-translate-y-0.5 uppercase tracking-widest text-xs"
                            >
                                Proceed to Checkout
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div
                    v-else
                    class="bg-white rounded-[2.5rem] p-12 text-center border border-gray-100 shadow-xl shadow-gray-200/50"
                >
                    <div
                        class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6"
                    >
                        <svg
                            class="w-10 h-10 text-gray-300"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                            />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 mb-4">
                        Your cart is empty
                    </h2>
                    <p class="text-gray-500 mb-8 max-w-sm mx-auto">
                        Explore our collection of premium cards and gifts to
                        find something you love.
                    </p>
                    <Link
                        :href="route('home')"
                        class="inline-flex items-center justify-center rounded-xl bg-primary px-8 py-3 text-sm font-black text-white shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all hover:-translate-y-0.5"
                        >Start Shopping</Link
                    >
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(20px, -20px) scale(1.1);
    }
    66% {
        transform: translate(-10px, 10px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}
.animate-blob {
    animation: blob 10s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
</style>
