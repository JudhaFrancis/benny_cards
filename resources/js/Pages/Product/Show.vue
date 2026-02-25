<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProductHero from "./Components/ProductHero.vue";
import ProductGallery from "./Components/ProductGallery.vue";
import ProductInfo from "./Components/ProductInfo.vue";
import ProductTabs from "./Components/ProductTabs.vue";
import RelatedProducts from "./Components/RelatedProducts.vue";

defineProps({
    product: {
        type: Object,
        required: true,
    },
    relatedProducts: {
        type: Array,
        default: () => [],
    },
    averageRating: {
        type: String,
        default: "0.0",
    },
    imageBaseUrl: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head :title="product.title" />

    <AuthenticatedLayout>
        <ProductHero :product="product" />

        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 lg:items-start">
                    <ProductGallery :product="product" />
                    <ProductInfo
                        :product="product"
                        :averageRating="averageRating"
                    />
                </div>

                <ProductTabs :product="product" :imageBaseUrl="imageBaseUrl" />

                <RelatedProducts
                    :product="product"
                    :relatedProducts="relatedProducts"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Component-specific styles are handled within sub-components */
</style>
