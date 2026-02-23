<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const props = defineProps({
    banners: {
        type: Array,
        default: () => [],
    },
});

const currentSlide = ref(0);
let intervalId = null;

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % props.banners.length;
};

const prevSlide = () => {
    currentSlide.value =
        (currentSlide.value - 1 + props.banners.length) % props.banners.length;
};

const startAutoPlay = () => {
    if (props.banners.length > 1) {
        intervalId = setInterval(nextSlide, 5000);
    }
};

const stopAutoPlay = () => {
    if (intervalId) {
        clearInterval(intervalId);
    }
};

onMounted(() => {
    startAutoPlay();
});

onUnmounted(() => {
    stopAutoPlay();
});
</script>

<template>
    <div class="w-full px-3 md:px-2">
        <!-- Hero Slider -->
        <div
            v-if="banners.length > 0"
            class="relative w-full transition-all duration-500 overflow-hidden bg-white rounded-[2rem]"
            @mouseenter="stopAutoPlay"
            @mouseleave="startAutoPlay"
        >
            <div
                v-for="(banner, index) in banners"
                :key="banner.id"
                class="transition-opacity duration-1000 ease-in-out"
                :class="{
                    'relative block': currentSlide === index,
                    'absolute inset-0': currentSlide !== index,
                    'opacity-100': currentSlide === index,
                    'opacity-0': currentSlide !== index,
                    'z-10': currentSlide === index,
                }"
            >
                <!-- Background Image -->
                <img
                    :src="banner.photo"
                    :alt="banner.title"
                    class="w-full h-auto transform scale-105 transition-transform duration-[20000ms] ease-linear"
                    :class="currentSlide === index ? 'scale-110' : 'scale-100'"
                />

                <!-- Gradient Overlay -->
                <div
                    class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"
                ></div>
            </div>

            <!-- Slider Controls -->
            <button
                v-if="banners.length > 1"
                @click="prevSlide"
                class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-lg text-white p-3 rounded-full transition-all duration-300 z-20 group border border-white/20 hover:border-white/40 shadow-lg hover:shadow-primary/20 hover:scale-110"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1"
                    stroke="currentColor"
                    class="w-5 h-5 group-hover:-translate-x-1 transition-transform duration-300"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 19.5L8.25 12l7.5-7.5"
                    />
                </svg>
            </button>
            <button
                v-if="banners.length > 1"
                @click="nextSlide"
                class="absolute right-6 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-lg text-white p-3 rounded-full transition-all duration-300 z-20 group border border-white/20 hover:border-white/40 shadow-lg hover:shadow-primary/20 hover:scale-110"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2.5"
                    stroke="currentColor"
                    class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8.25 4.5l7.5 7.5-7.5 7.5"
                    />
                </svg>
            </button>

            <!-- Indicators -->
            <div
                v-if="banners.length > 1"
                class="absolute bottom-10 left-1/2 -translate-x-1/2 flex space-x-4 z-20"
            >
                <button
                    v-for="(banner, index) in banners"
                    :key="'dot-' + index"
                    @click="currentSlide = index"
                    class="transition-all duration-300 rounded-full"
                    :class="
                        currentSlide === index
                            ? 'w-10 h-3 bg-primary shadow-lg shadow-primary/50 scale-110'
                            : 'w-3 h-3 bg-white/40 hover:bg-white/60 border-2 border-white/60 hover:scale-110'
                    "
                ></button>
            </div>
        </div>

        <div
            v-else
            class="w-full h-[300px] flex items-center justify-center bg-gray-50 rounded-[2rem] border border-dashed border-gray-200 text-gray-400"
        >
            No banners available
        </div>
    </div>
</template>
