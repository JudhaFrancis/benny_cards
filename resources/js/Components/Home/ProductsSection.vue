<script setup>
import { Link } from "@inertiajs/vue3";
import ProductCard from "@/Components/ProductCard.vue";
defineProps({
    products: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <!-- Latest Products Section -->
    <div id="products" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Latest Products
                </h2>
                <div class="h-1 w-20 bg-primary mx-auto rounded-full"></div>
            </div>

            <!-- Cards Grid -->
            <div
                v-if="products.length > 0"
                class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6"
            >
                <ProductCard
                    v-for="product in products"
                    :key="product.id"
                    :product="product"
                />
            </div>

            <div v-else class="text-center py-12 text-gray-500">
                <p class="text-lg">No new products available at the moment.</p>
            </div>
        </div>
    </div>
</template>
