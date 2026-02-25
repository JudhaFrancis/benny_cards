<script setup>
import { Link } from "@inertiajs/vue3";
import ProductCard from "@/Components/ProductCard.vue";
defineProps({
    invitationCards: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <!-- Invitation Cards Section -->
    <div v-if="invitationCards.length > 0" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">
                    Invitation Cards
                </h2>
                <Link
                    :href="route('category.index')"
                    class="text-primary hover:text-primary/80 font-medium transition-colors"
                    >View All →</Link
                >
            </div>

            <!-- Cards Grid -->
            <div
                class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6"
            >
                <ProductCard
                    v-for="product in invitationCards"
                    :key="product.id"
                    :product="product"
                />
            </div>
        </div>
    </div>
</template>
