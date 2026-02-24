<script setup>
defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <!-- Image gallery -->
    <div class="flex flex-col">
        <div
            class="w-full aspect-square rounded-3xl overflow-hidden bg-gray-50 border border-gray-100 shadow-sm group"
        >
            <img
                :src="product.photo"
                :alt="product.title"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
            />
        </div>
    </div>
</template>
