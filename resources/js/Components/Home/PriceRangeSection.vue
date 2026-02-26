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
    <div v-if="priceRanges.length > 0" class="py-20 bg-gray-50">
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
                    class="group relative h-48 sm:h-64 rounded-xl sm:rounded-2xl overflow-hidden cursor-pointer shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-1 sm:hover:-translate-y-2"
                >
                    <!-- Background Image -->
                    <img
                        v-if="range.photo"
                        :src="range.photo"
                        :alt="range.label"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                    />
                    <div
                        v-else
                        class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center"
                    >
                        <svg
                            class="w-16 h-16 text-gray-300"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </div>

                    <!-- Overlays -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent group-hover:via-black/50 transition-colors duration-300"
                    ></div>

                    <!-- Content -->
                    <div
                        class="absolute inset-0 p-4 sm:p-8 flex flex-col justify-end text-center"
                    >
                        <h3
                            class="text-base sm:text-2xl font-bold text-white mb-1 sm:mb-2 transform group-hover:scale-110 transition-transform duration-300"
                        >
                            {{ range.label }}
                        </h3>
                        <div
                            class="flex items-center justify-center gap-2 text-white/80 text-[10px] sm:text-sm font-medium"
                        >
                            <span
                                class="px-2 sm:px-3 py-0.5 sm:py-1 bg-white/20 backdrop-blur-md rounded-full border border-white/30 whitespace-nowrap"
                            >
                                {{ range.count }} Products
                            </span>
                        </div>

                        <!-- Hover Button -->
                        <div
                            class="mt-2 sm:mt-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden sm:block"
                        >
                            <span
                                class="text-white text-sm font-semibold flex items-center justify-center gap-1"
                            >
                                View Products
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9 5l7 7-7 7"
                                    ></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>
