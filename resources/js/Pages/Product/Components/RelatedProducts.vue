<script setup>
import { Link } from "@inertiajs/vue3";
import ProductCard from "@/Components/ProductCard.vue";

defineProps({
    product: {
        type: Object,
        required: true,
    },
    relatedProducts: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <!-- Related products -->
    <section
        aria-labelledby="related-heading"
        class="mt-24"
        v-if="relatedProducts.length > 0"
    >
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <h2
                    id="related-heading"
                    class="text-2xl font-black text-gray-900 tracking-tight"
                >
                    Related Products
                </h2>
                <div
                    class="h-1 w-12 bg-primary rounded-full hidden sm:block"
                ></div>
            </div>
            <Link
                :href="
                    product.category
                        ? route('category.index', product.category.slug)
                        : route('home')
                "
                class="inline-flex items-center gap-2 text-sm font-bold text-primary border border-primary/30 bg-primary/5 hover:bg-primary hover:text-white px-4 py-2 rounded-full transition-all duration-200 group"
            >
                Explore More
                <svg
                    class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                    />
                </svg>
            </Link>
        </div>

        <div
            class="grid grid-cols-2 gap-4 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4 lg:gap-8"
        >
            <ProductCard
                v-for="relProduct in relatedProducts"
                :key="relProduct.id"
                :product="relProduct"
            />
        </div>
    </section>
</template>
