<script setup>
import { ref, computed } from "vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    cartItems: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    name: "",
    email: "",
    phone: "",
    address_1: "",
    address_2: "",
    remarks: "",
});

const subtotal = computed(() => {
    return props.cartItems.reduce((acc, item) => acc + parseFloat(item.amount || 0), 0);
});

const formatPrice = (price) => {
    return new Intl.NumberFormat("en-IN", {
        style: "currency",
        currency: "INR",
        minimumFractionDigits: 2,
    }).format(price);
};

const submitOrder = () => {
    form.post(route("checkout.store"), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Checkout" />

    <AuthenticatedLayout :transparent-header="false">
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
                                <span class="text-gray-400">Checkout</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl md:text-3xl font-black text-white px-4">
                    Secure Checkout
                </h1>
            </div>
        </div>

        <div class="py-20 md:py-24 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Checkout Form -->
                    <div class="flex-1">
                        <div
                            class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-gray-100 shadow-xl shadow-gray-200/50"
                        >
                            <h2
                                class="text-2xl font-black text-gray-900 mb-8 uppercase tracking-tight"
                            >
                                Order Details
                            </h2>

                            <form
                                id="checkout-form"
                                @submit.prevent="submitOrder"
                                class="space-y-10"
                            >
                                <!-- Customer Information -->
                                <div
                                    class="bg-gray-50/50 p-6 md:p-8 rounded-[2rem] border border-gray-100/80 shadow-sm"
                                >
                                    <h3
                                        class="flex items-center gap-3 text-sm font-black text-gray-900 mb-6 uppercase tracking-widest pb-4 border-b border-gray-200"
                                    >
                                        <div
                                            class="w-8 h-8 rounded-full bg-primary text-white flex flex-col items-center justify-center text-xs shadow-lg shadow-primary/30"
                                        >
                                            1
                                        </div>
                                        Customer Information
                                    </h3>
                                    <div class="space-y-6">
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider"
                                                >Full Name *</label
                                            >
                                            <input
                                                v-model="form.name"
                                                type="text"
                                                class="w-full bg-white border border-gray-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm text-sm"
                                                required
                                                placeholder="John Doe"
                                            />
                                            <p
                                                v-if="form.errors.name"
                                                class="mt-2 text-[10px] text-red-500 font-bold uppercase"
                                            >
                                                {{ form.errors.name }}
                                            </p>
                                        </div>
                                        <div
                                            class="grid grid-cols-1 md:grid-cols-2 gap-6"
                                        >
                                            <div>
                                                <label
                                                    class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider"
                                                    >Email Address</label
                                                >
                                                <input
                                                    v-model="form.email"
                                                    type="email"
                                                    class="w-full bg-white border border-gray-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm text-sm"
                                                    placeholder="john@example.com"
                                                />
                                                <p
                                                    v-if="form.errors.email"
                                                    class="mt-2 text-[10px] text-red-500 font-bold uppercase"
                                                >
                                                    {{ form.errors.email }}
                                                </p>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider"
                                                    >Phone Number *</label
                                                >
                                                <input
                                                    v-model="form.phone"
                                                    type="tel"
                                                    class="w-full bg-white border border-gray-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm text-sm"
                                                    required
                                                    placeholder="+91 98765 43210"
                                                />
                                                <p
                                                    v-if="form.errors.phone"
                                                    class="mt-2 text-[10px] text-red-500 font-bold uppercase"
                                                >
                                                    {{ form.errors.phone }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Primary Address -->
                                <div
                                    class="bg-gray-50/50 p-6 md:p-8 rounded-[2rem] border border-gray-100/80 shadow-sm"
                                >
                                    <h3
                                        class="flex items-center gap-3 text-sm font-black text-gray-900 mb-6 uppercase tracking-widest pb-4 border-b border-gray-200"
                                    >
                                        <div
                                            class="w-8 h-8 rounded-full bg-primary text-white flex flex-col items-center justify-center text-xs shadow-lg shadow-primary/30"
                                        >
                                            2
                                        </div>
                                        Primary Address
                                    </h3>
                                    <div class="space-y-6">
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wider"
                                                >Address *</label
                                            >
                                            <textarea
                                                v-model="form.address_1"
                                                rows="3"
                                                class="w-full bg-white border border-gray-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all shadow-sm text-sm"
                                                required
                                                placeholder="Enter your full address here"
                                            ></textarea>
                                            <p
                                                v-if="form.errors.address_1"
                                                class="mt-2 text-[10px] text-red-500 font-bold uppercase"
                                            >
                                                {{ form.errors.address_1 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Secondary Address -->
                                <div
                                    class="bg-gray-50/20 p-6 md:p-8 rounded-[2rem] border border-gray-100/30"
                                >
                                    <h3
                                        class="flex items-center gap-3 text-sm font-black text-gray-400 mb-6 uppercase tracking-widest pb-4 border-b border-gray-100"
                                    >
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex flex-col items-center justify-center text-xs"
                                        >
                                            3
                                        </div>
                                        Secondary Address
                                        <span
                                            class="text-[10px] font-bold text-gray-400 normal-case ml-2"
                                            >(Optional)</span
                                        >
                                    </h3>
                                    <div class="space-y-6">
                                        <div>
                                            <label
                                                class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider"
                                                >Secondary Address</label
                                            >
                                            <textarea
                                                v-model="form.address_2"
                                                rows="3"
                                                class="w-full bg-white border border-gray-200 rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all text-sm"
                                                placeholder="Any secondary location details"
                                            ></textarea>
                                            <p
                                                v-if="form.errors.address_2"
                                                class="mt-2 text-[10px] text-red-500 font-bold uppercase"
                                            >
                                                {{ form.errors.address_2 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Remarks -->
                                <div
                                    class="bg-gray-50/20 p-6 md:p-8 rounded-[2rem] border border-gray-100/30"
                                >
                                    <h3
                                        class="flex items-center gap-3 text-sm font-black text-gray-400 mb-6 uppercase tracking-widest pb-4 border-b border-gray-100"
                                    >
                                        <div
                                            class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex flex-col items-center justify-center text-xs"
                                        >
                                            4
                                        </div>
                                        Order Remarks
                                    </h3>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider"
                                            >Additional Notes
                                            <span
                                                class="text-[10px] normal-case ml-1"
                                                >(Optional)</span
                                            ></label
                                        >
                                        <textarea
                                            v-model="form.remarks"
                                            rows="4"
                                            class="w-full bg-white border border-gray-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-4 focus:ring-primary/5 focus:border-primary transition-all text-sm resize-y"
                                            placeholder="Any specific requirements regarding your delivery?"
                                        ></textarea>
                                        <p
                                            v-if="form.errors.remarks"
                                            class="mt-2 text-[10px] text-red-500 font-bold uppercase"
                                        >
                                            {{ form.errors.remarks }}
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="w-full lg:w-96">
                        <div
                            class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-xl shadow-gray-200/50 sticky top-24"
                        >
                            <h2
                                class="text-xl font-black text-gray-900 mb-6 uppercase tracking-tight"
                            >
                                Order Summary
                            </h2>

                            <div
                                class="space-y-4 mb-6 max-h-64 overflow-y-auto pr-2 custom-scrollbar"
                            >
                                <div
                                    v-for="item in cartItems"
                                    :key="item.id"
                                    class="flex gap-4"
                                >
                                    <div
                                        class="w-16 h-16 bg-gray-50 rounded-xl overflow-hidden flex-shrink-0 border border-gray-100"
                                    >
                                        <img
                                            v-if="item.product.photo"
                                            :src="item.product.photo"
                                            :alt="item.product.title"
                                            class="w-full h-full object-cover"
                                        />
                                    </div>
                                    <div
                                        class="flex-1 min-w-0 flex flex-col justify-center"
                                    >
                                        <h4
                                            class="text-sm font-bold text-gray-900 truncate"
                                        >
                                            {{ item.product.title }}
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            Qty: {{ item.quantity }}
                                        </p>
                                        <p
                                            class="text-sm font-bold text-primary mt-1"
                                        >
                                            {{ formatPrice(item.price) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="space-y-4 mb-8 pt-6 border-t border-gray-100"
                            >
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

                            <button
                                type="submit"
                                form="checkout-form"
                                :disabled="form.processing"
                                class="w-full bg-primary text-white font-black py-4 rounded-2xl shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all hover:-translate-y-0.5 uppercase tracking-widest text-xs disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {{
                                    form.processing
                                        ? "Processing..."
                                        : "Place Order"
                                }}
                            </button>
                        </div>
                    </div>
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

/* Custom Scrollbar for Cart Items Summary */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: #f9fafb;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 4px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #d1d5db;
}
</style>
