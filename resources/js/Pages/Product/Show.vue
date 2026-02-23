<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProductCard from "@/Components/ProductCard.vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    relatedProducts: {
        type: Array,
        default: () => [],
    },
});

const calculateOriginalPrice = (price, discount) => {
    if (!discount || discount <= 0) return null;
    return (price / (1 - discount / 100)).toFixed(2);
};
</script>

<template>
    <Head :title="product.title" />

    <AuthenticatedLayout>
        <!-- Compact Hero Section (Synced with Contact Us Design) -->
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
                        <li v-if="product.category">
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
                                <Link
                                    :href="
                                        route(
                                            'category.index',
                                            product.category.slug,
                                        )
                                    "
                                    class="hover:text-primary transition-colors text-primary"
                                    >{{ product.category.title }}</Link
                                >
                            </div>
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
                                <span class="text-gray-400">Details</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1
                    class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-2"
                >
                    Product Details
                </h1>
                <h2 class="text-3xl md:text-5xl font-black mb-4 px-4">
                    {{ product.title }}
                    <span class="text-primary italic">Signature</span>
                </h2>
                <div
                    class="flex items-center justify-center gap-4 text-sm font-bold text-gray-500 uppercase tracking-widest"
                >
                    <span>Premium Collection</span>
                    <span class="w-1 h-1 bg-gray-700 rounded-full"></span>
                    <span>Handcrafted Quality</span>
                </div>
            </div>
        </div>

        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
                    <!-- Image gallery -->
                    <div class="flex flex-col">
                        <div
                            class="w-full aspect-square rounded-3xl overflow-hidden bg-gray-50 border border-gray-100 shadow-sm group"
                        >
                            <img
                                :src="product.photo"
                                :alt="product.title"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                            />
                        </div>
                    </div>

                    <!-- Product info -->
                    <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                        <div
                            class="flex items-center justify-between gap-4 mb-4"
                        >
                            <div
                                class="text-[10px] uppercase tracking-wider font-bold px-3 py-1.5 rounded-full shadow-sm border"
                                :class="{
                                    'bg-indigo-50 text-indigo-700 border-indigo-200/50':
                                        product.type === 'card',
                                    'bg-purple-50 text-purple-700 border-purple-200/50':
                                        product.type === 'gift',
                                }"
                            >
                                {{
                                    product.type === "card"
                                        ? "Invitation"
                                        : "Gift"
                                }}
                            </div>

                            <div
                                v-if="
                                    product.condition &&
                                    product.condition !== 'default'
                                "
                                class="text-[10px] uppercase tracking-wider font-bold px-3 py-1.5 rounded-full shadow-sm border"
                                :class="{
                                    'bg-emerald-50 text-emerald-700 border-emerald-200/50':
                                        product.condition === 'new',
                                    'bg-orange-50 text-orange-700 border-orange-200/50':
                                        product.condition === 'hot',
                                    'bg-blue-50 text-blue-700 border-blue-200/50':
                                        product.condition === 'trending',
                                }"
                            >
                                {{ product.condition }}
                            </div>
                        </div>

                        <h1
                            class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl mb-4"
                        >
                            {{ product.title }}
                        </h1>

                        <div class="mt-6 flex items-baseline gap-4">
                            <h2 class="sr-only">Product information</h2>
                            <p class="text-4xl font-black text-primary">
                                ₹{{ product.price }}
                            </p>
                            <p
                                v-if="product.discount > 0"
                                class="text-xl text-gray-400 line-through"
                            >
                                ₹{{
                                    calculateOriginalPrice(
                                        product.price,
                                        product.discount,
                                    )
                                }}
                            </p>
                            <span
                                v-if="product.discount > 0"
                                class="text-sm font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg"
                            >
                                {{ product.discount }}% OFF
                            </span>
                        </div>

                        <div class="mt-6">
                            <h3 class="sr-only">Description</h3>
                            <div
                                class="text-lg text-gray-600 leading-relaxed"
                                v-html="product.summary"
                            ></div>
                        </div>

                        <div class="mt-10 flex flex-col sm:flex-row gap-4">
                            <button
                                type="button"
                                class="flex-1 bg-cyan-400 border border-transparent rounded-2xl py-4 px-8 flex items-center justify-center text-lg font-bold text-white hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-all transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-cyan-200"
                            >
                                <svg
                                    class="w-6 h-6 mr-3"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                    />
                                </svg>
                                Add to Cart
                            </button>

                            <button
                                type="button"
                                class="w-full sm:w-16 bg-white border-2 border-gray-100 rounded-2xl py-4 flex items-center justify-center text-gray-400 hover:text-red-500 hover:border-red-100 hover:bg-red-50 transition-all group shadow-sm"
                            >
                                <svg
                                    class="w-6 h-6 group-hover:fill-current"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                    />
                                </svg>
                                <span class="sr-only">Add to wishlist</span>
                            </button>
                        </div>

                        <!-- Product details/tabs -->
                        <div class="mt-12 border-t border-gray-100 pt-8">
                            <h3
                                class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-4"
                            >
                                Detailed Description
                            </h3>
                            <div
                                class="prose prose-sm text-gray-500 max-w-none"
                                v-html="
                                    product.description ||
                                    'No detailed description available.'
                                "
                            ></div>
                        </div>

                        <!-- Trust Badges -->
                        <div class="mt-8 grid grid-cols-2 gap-4">
                            <div
                                class="flex items-center gap-3 p-4 rounded-2xl bg-gray-50 border border-gray-100"
                            >
                                <div
                                    class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary"
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
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.040L3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622l-0.382-3.016z"
                                        />
                                    </svg>
                                </div>
                                <span
                                    class="text-xs font-bold text-gray-700 uppercase"
                                    >Secure Payment</span
                                >
                            </div>
                            <div
                                class="flex items-center gap-3 p-4 rounded-2xl bg-gray-50 border border-gray-100"
                            >
                                <div
                                    class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary"
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
                                            d="M13 10V3L4 14h7v7l9-11h-7z"
                                        />
                                    </svg>
                                </div>
                                <span
                                    class="text-xs font-bold text-gray-700 uppercase"
                                    >Fast Delivery</span
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related products -->
                <section
                    aria-labelledby="related-heading"
                    class="mt-24"
                    v-if="relatedProducts.length > 0"
                >
                    <div class="flex items-center justify-between mb-8">
                        <h2
                            id="related-heading"
                            class="text-2xl font-black text-gray-900 tracking-tight"
                        >
                            Related Products
                        </h2>
                        <div class="h-1 w-20 bg-primary rounded-full"></div>
                    </div>

                    <div
                        class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-4 xl:gap-x-8"
                    >
                        <ProductCard
                            v-for="relProduct in relatedProducts"
                            :key="relProduct.id"
                            :product="relProduct"
                        />
                    </div>
                </section>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.prose :deep(p) {
    margin-bottom: 1rem;
}
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
