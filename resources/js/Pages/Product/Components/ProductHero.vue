<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <!-- Compact Hero Section (Synced with Contact Us Design) -->
    <div class="relative bg-gray-900 py-12 md:py-20 overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 z-0">
            <div
                class="absolute top-0 -left-4 w-48 h-48 bg-primary/20 rounded-full blur-3xl opacity-20 animate-blob"
            ></div>
            <div
                class="absolute bottom-0 -right-4 w-48 h-48 bg-blue-500/20 rounded-full blur-3xl opacity-20 animate-blob animation-delay-2000"
            ></div>
        </div>

        <div
            class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white"
        >
            <!-- Breadcrumbs -->
            <nav class="flex justify-center mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-3">
                    <li>
                        <Link
                            :href="route('home')"
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-500 hover:text-primary transition-colors"
                            >Home</Link
                        >
                    </li>
                    <li
                        v-if="product.category"
                        class="flex items-center space-x-3"
                    >
                        <span class="text-gray-800">/</span>
                        <Link
                            :href="
                                route('category.index', product.category.slug)
                            "
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-primary hover:text-white transition-colors"
                            >{{ product.category.title }}</Link
                        >
                    </li>
                    <li class="flex items-center space-x-3">
                        <span class="text-gray-800">/</span>
                        <span
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400"
                            >Details</span
                        >
                    </li>
                </ol>
            </nav>

            <h1
                class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-3"
            >
                Product Details
            </h1>
            <h2 class="text-3xl md:text-4xl font-black mb-4 px-4">
                {{ product.title }}
                <span class="text-primary italic">Signature</span>
            </h2>
            <div
                class="flex items-center justify-center gap-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest"
            >
                <span>Premium Collection</span>
                <span class="w-1 h-1 bg-gray-700 rounded-full"></span>
                <span>Handcrafted Quality</span>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(20px, -20px) scale(1.1);
    }
    66% {
        transform: translate(-10px, 10px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}
.animate-blob {
    animation: blob 10s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
</style>
