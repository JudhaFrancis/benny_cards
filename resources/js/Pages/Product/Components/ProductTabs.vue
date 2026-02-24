<script setup>
import { ref } from "vue";
import ProductReviews from "./ProductReviews.vue";

defineProps({
    product: {
        type: Object,
        required: true,
    },
    imageBaseUrl: {
        type: String,
        required: true,
    },
});

const activeTab = ref("description");
</script>

<template>
    <!-- Description / Reviews Tabs -->
    <div class="mt-16 border-t border-gray-100 pt-10">
        <!-- Tab Headers -->
        <div class="flex gap-0 border-b border-gray-200">
            <button
                @click="activeTab = 'description'"
                :class="[
                    'px-6 py-3 text-sm font-bold uppercase tracking-widest transition-all duration-200 border-b-2 -mb-px',
                    activeTab === 'description'
                        ? 'border-primary text-primary'
                        : 'border-transparent text-gray-400 hover:text-gray-700',
                ]"
            >
                Description
            </button>
            <button
                @click="activeTab = 'reviews'"
                :class="[
                    'px-6 py-3 text-sm font-bold uppercase tracking-widest transition-all duration-200 border-b-2 -mb-px',
                    activeTab === 'reviews'
                        ? 'border-primary text-primary'
                        : 'border-transparent text-gray-400 hover:text-gray-700',
                ]"
            >
                Customer Reviews
            </button>
        </div>

        <!-- Tab Content -->
        <div class="py-8">
            <!-- Description Tab -->
            <div v-if="activeTab === 'description'">
                <div
                    class="prose prose-sm text-gray-600 max-w-none"
                    v-html="
                        product.description ||
                        'No detailed description available.'
                    "
                ></div>
            </div>

            <!-- Reviews Tab -->
            <div v-else-if="activeTab === 'reviews'">
                <ProductReviews
                    :product="product"
                    :imageBaseUrl="imageBaseUrl"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>
.prose :deep(p) {
    margin-bottom: 1rem;
}
</style>
