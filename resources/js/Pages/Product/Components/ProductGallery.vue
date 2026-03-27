<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const mainImage = ref(props.product.photo);
const productImages = ref([]);

onMounted(() => {
    // Combine main photo with all gallery images
    const images = [];
    if (props.product.photo) {
        images.push(props.product.photo);
    }
    
    if (props.product.images && props.product.images.length > 0) {
        props.product.images.forEach(img => {
            // Avoid duplicating main photo if it's already in the gallery
            if (img.image_path !== props.product.photo) {
                images.push(img.image_path);
            }
        });
    }
    
    productImages.value = images;
    // mainImage is already initialized to props.product.photo
});

const setMainImage = (image) => {
    mainImage.value = image;
};
</script>

<template>
    <!-- Image gallery -->
    <div class="flex flex-col sm:flex-row gap-4">
        <!-- Thumbnails (Left side on desktop, bottom on mobile) -->
        <div v-if="productImages.length > 1" class="flex sm:flex-col gap-3 overflow-x-auto sm:overflow-y-auto sm:overflow-x-hidden order-last sm:order-first pb-2 sm:pb-0 sm:pr-2 snap-x sm:snap-y scrollbar-hide shrink-0" style="max-height: 500px;">
            <button
                v-for="(image, index) in productImages"
                :key="index"
                @click="setMainImage(image)"
                class="relative h-20 w-20 flex-shrink-0 cursor-pointer overflow-hidden rounded-xl border-2 transition-all aspect-square snap-center"
                :class="mainImage === image ? 'border-cyan-500 scale-100 shadow-md' : 'border-transparent hover:border-gray-200 opacity-70 hover:opacity-100 scale-95 hover:scale-100 shadow-sm'"
            >
                <img
                    :src="image"
                    :alt="`${product.title} - Image ${index + 1}`"
                    class="h-full w-full object-cover bg-white"
                />
            </button>
        </div>

        <div
            class="w-full flex-1 aspect-square rounded-3xl overflow-hidden bg-gray-50 border border-gray-100 shadow-sm group"
        >
            <img
                :src="mainImage"
                :alt="product.title"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
            />
        </div>
    </div>
</template>
