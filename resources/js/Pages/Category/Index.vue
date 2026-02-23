<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProductCard from "@/Components/ProductCard.vue";

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
    selectedCategory: {
        type: Object,
        default: () => null,
    },
    products: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head :title="selectedCategory ? selectedCategory.title : 'Categories'" />

    <AuthenticatedLayout>
        <!-- Compact Hero Section (Synced with Contact Us Design) -->
        <div
            class="relative bg-gray-900 py-12 md:py-16 overflow-hidden"
            v-if="selectedCategory"
        >
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
                        </li>
                        <li class="text-primary">Categories</li>
                    </ol>
                </nav>

                <h1
                    class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-2"
                >
                    Shopping Experience
                </h1>
                <h2 class="text-3xl md:text-5xl font-black mb-4">
                    {{ selectedCategory.title }}
                    <span class="text-primary italic">Collection</span>
                </h2>
                <p
                    class="text-gray-400 text-base md:text-lg max-w-xl mx-auto leading-relaxed opacity-80"
                    v-if="selectedCategory.summary"
                >
                    {{ selectedCategory.summary }}
                </p>

                <!-- Product Count Badge -->
                <div
                    class="mt-6 inline-flex items-center gap-2 px-6 py-2.5 bg-white/5 backdrop-blur-xl border border-white/10 rounded-full text-sm font-bold text-gray-400"
                >
                    <span
                        class="w-2 h-2 rounded-full bg-primary animate-pulse"
                    ></span>
                    <span>{{ products.length }} Products Available</span>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Sidebar: Categories -->
                    <aside class="w-full md:w-64 flex-shrink-0">
                        <div
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg sticky top-24"
                        >
                            <div class="p-6">
                                <h3
                                    class="font-bold text-lg mb-4 text-gray-900 border-b pb-2"
                                >
                                    Categories
                                </h3>
                                <ul class="space-y-3">
                                    <li
                                        v-for="category in categories"
                                        :key="category.id"
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'category.index',
                                                    category.slug,
                                                )
                                            "
                                            class="flex items-center gap-3 p-2 rounded-lg transition-all duration-200 group"
                                            :class="{
                                                'bg-primary/10 text-primary font-semibold':
                                                    selectedCategory?.id ===
                                                    category.id,
                                                'hover:bg-gray-50 text-gray-600':
                                                    selectedCategory?.id !==
                                                    category.id,
                                            }"
                                        >
                                            <div
                                                class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0 bg-gray-100 border border-gray-200"
                                            >
                                                <img
                                                    v-if="category.photo"
                                                    :src="category.photo"
                                                    :alt="category.title"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                                />
                                                <div
                                                    v-else
                                                    class="w-full h-full flex items-center justify-center bg-primary/5"
                                                >
                                                    <svg
                                                        class="w-5 h-5 text-primary/40"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                                                        ></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <span class="text-sm truncate">{{
                                                category.title
                                            }}</span>
                                            <span
                                                class="ml-auto text-[10px] bg-gray-100 px-1.5 py-0.5 rounded-full text-gray-400 group-hover:bg-primary/10 group-hover:text-primary transition-colors"
                                            >
                                                {{ category.products_count }}
                                            </span>
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </aside>

                    <!-- Main Content: Products -->
                    <main class="flex-1">
                        <div v-if="products.length > 0">
                            <!-- Cards Grid -->
                            <div
                                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
                            >
                                <div
                                    v-for="product in products"
                                    :key="product.id"
                                >
                                    <ProductCard :product="product" />
                                </div>
                            </div>
                        </div>

                        <div
                            v-else
                            class="bg-white rounded-2xl p-12 text-center shadow-sm border border-gray-100"
                        >
                            <div
                                class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4"
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
                                        stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                    ></path>
                                </svg>
                            </div>
                            <h3
                                class="text-xl font-semibold text-gray-900 mb-2"
                            >
                                No products found
                            </h3>
                            <p class="text-gray-500">
                                We couldn't find any products in this category
                                at the moment.
                            </p>
                            <Link
                                :href="route('home')"
                                class="mt-6 inline-flex items-center text-primary font-medium hover:underline"
                            >
                                ← Back to shopping
                            </Link>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.sticky {
    top: 6rem;
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
