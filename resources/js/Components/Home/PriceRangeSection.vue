<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    priceRanges: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <!-- Shop by Price Range Section -->
    <div v-if="priceRanges.length > 0" class="pt-4 pb-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span
                    class="text-primary text-sm font-semibold tracking-wider uppercase mb-2 block"
                    >Quick Filtering</span
                >
                <h2 class="text-4xl font-bold text-gray-900 mb-4">
                    Shop by Price Range
                </h2>
                <div class="h-1 w-20 bg-primary mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-8">
                <Link
                    v-for="(range, index) in priceRanges"
                    :key="index"
                    :href="route('category.index', { price_range: range.slug })"
                    class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 flex flex-col border border-gray-100"
                >
                    <!-- Image Area (Full width, no padding) -->
                    <div class="relative aspect-square overflow-hidden bg-gray-50">
                        <img
                            v-if="range.photo"
                            :src="range.photo"
                            :alt="range.label"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        />
                        <div
                            v-else
                            class="w-full h-full flex items-center justify-center text-gray-200"
                        >
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="px-5 pb-6 pt-5 sm:px-6 sm:pb-7 sm:pt-6 mt-0 relative z-20 text-center flex flex-col items-center">
                        <h3 class="text-sm sm:text-lg font-black text-gray-900 mb-1">
                            {{ range.label }}
                        </h3>
                        
                        <!-- View Products -->
                        <div class="mt-1">
                            <span class="text-primary text-xs sm:text-sm font-black flex items-center justify-center gap-1 tracking-widest transition-transform duration-300 group-hover:translate-x-1">
                                View products
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>
