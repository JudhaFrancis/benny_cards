<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
});

const categorySlider = ref(null);

const scrollCategories = (direction) => {
    if (categorySlider.value) {
        const scrollAmount = 300;
        categorySlider.value.scrollBy({
            left: direction === "next" ? scrollAmount : -scrollAmount,
            behavior: "smooth",
        });
    }
};
</script>

<template>
    <!-- Browse by Category Section -->
    <div v-if="categories.length > 0" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">
                    Browse by Category
                </h2>
                <Link
                    :href="route('category.index')"
                    class="text-primary hover:text-primary/80 font-medium"
                    >View More →</Link
                >
            </div>

            <!-- Slider Container -->
            <div class="relative">
                <!-- Previous Button -->
                <button
                    @click="scrollCategories('prev')"
                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 bg-white hover:bg-gray-50 text-gray-800 p-3 rounded-full shadow-lg z-10 transition-all duration-300 hover:scale-110 border border-gray-200"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="w-5 h-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 19.5L8.25 12l7.5-7.5"
                        />
                    </svg>
                </button>

                <!-- Slider -->
                <div
                    ref="categorySlider"
                    class="flex gap-6 overflow-x-auto scrollbar-hide scroll-smooth snap-x snap-mandatory"
                    style="scrollbar-width: none; -ms-overflow-style: none"
                >
                    <Link
                        v-for="category in categories"
                        :key="category.id"
                        :href="route('category.index', category.slug)"
                        class="group cursor-pointer flex-shrink-0 w-64 snap-start"
                    >
                        <div
                            class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-primary/30"
                        >
                            <div
                                class="relative h-48 overflow-hidden bg-gray-100"
                            >
                                <img
                                    v-if="category.photo"
                                    :src="category.photo"
                                    :alt="category.title"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center bg-primary/10"
                                >
                                    <svg
                                        class="w-16 h-16 text-primary"
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
                                <!-- Overlay gradient and View More button -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                                ></div>
                                <div
                                    class="absolute bottom-3 right-3 px-3 py-1 text-xs bg-white text-primary font-medium rounded-full shadow-lg opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-300 hover:bg-primary hover:text-white"
                                >
                                    View →
                                </div>
                            </div>
                            <div
                                class="p-4 text-center bg-gray-50 group-hover:bg-primary/5 transition-colors"
                            >
                                <h3 class="font-semibold text-gray-900 mb-1">
                                    {{ category.title }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    {{ category.products_count }} items
                                </p>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- Next Button -->
                <button
                    @click="scrollCategories('next')"
                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 bg-white hover:bg-gray-50 text-gray-800 p-3 rounded-full shadow-lg z-10 transition-all duration-300 hover:scale-110 border border-gray-200"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="w-5 h-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M8.25 4.5l7.5 7.5-7.5 7.5"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>
