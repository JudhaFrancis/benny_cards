<script setup>
import ProductCard from "@/Components/ProductCard.vue";
defineProps({
    gifts: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <!-- Gifts Section -->
    <div v-if="gifts.length > 0" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Perfect Gifts</h2>
                <a
                    href="#"
                    class="text-primary hover:text-primary/80 font-medium transition-colors"
                    >View All →</a
                >
            </div>

            <!-- Cards Grid -->
            <div
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
            >
                <ProductCard
                    v-for="product in gifts"
                    :key="product.id"
                    :product="product"
                />
            </div>
        </div>
    </div>
</template>
