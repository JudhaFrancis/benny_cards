<script setup>
import ProductCard from "@/Components/ProductCard.vue";
defineProps({
    featuredProducts: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <!-- Featured Products Section -->
    <div v-if="featuredProducts.length > 0" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">
                    Featured Collection
                </h2>
                <a
                    href="#"
                    class="text-primary hover:text-primary/80 font-medium transition-colors"
                    >Explore All →</a
                >
            </div>

            <!-- Cards Grid -->
            <div
                class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6"
            >
                <ProductCard
                    v-for="product in featuredProducts"
                    :key="product.id"
                    :product="product"
                />
            </div>
        </div>
    </div>
</template>
