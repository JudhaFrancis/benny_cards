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
    <div
        class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 h-full flex flex-col relative"
    >
        <!-- Image Container -->
        <Link
            :href="route('product.show', product.slug)"
            class="relative aspect-square overflow-hidden block"
        >
            <img
                :src="product.photo"
                :alt="product.title"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
            />

            <!-- Badges Container (Top Left) -->
            <div class="absolute top-3 left-3 z-10 flex flex-col gap-2">
                <!-- Type/Condition Badge -->
                <div
                    v-if="product.type"
                    class="text-[10px] uppercase tracking-wider font-bold px-2.5 py-1 rounded-md shadow-sm border"
                    :class="{
                        'bg-indigo-50 text-indigo-700 border-indigo-200/50':
                            product.type === 'card',
                        'bg-purple-50 text-purple-700 border-purple-200/50':
                            product.type === 'gift',
                    }"
                >
                    {{ product.type === "card" ? "Invitation" : "Gift" }}
                </div>

                <div
                    v-else-if="
                        product.condition && product.condition !== 'default'
                    "
                    class="text-[10px] uppercase tracking-wider font-bold px-2.5 py-1 rounded-md shadow-sm border"
                    :class="{
                        'bg-emerald-50 text-emerald-700 border-emerald-200/50':
                            product.condition === 'new',
                        'bg-orange-50 text-orange-700 border-orange-200/50':
                            product.condition === 'hot',
                        'bg-blue-50 text-blue-700 border-blue-200/50':
                            product.condition === 'trending',
                    }"
                >
                    {{ product.condition }}
                </div>

                <!-- Discount Badge Removed -->
            </div>
            <!-- Add to Cart Icon (Bottom Right, always visible) -->
            <div class="absolute bottom-3 right-3 z-20">
                <button
                    class="p-2.5 bg-cyan-400 hover:bg-cyan-500 text-white rounded-lg shadow-lg transition-all duration-300 flex items-center justify-center hover:scale-110"
                    title="Add to Cart"
                >
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                        ></path>
                    </svg>
                </button>
            </div>
        </Link>

        <!-- Wishlist Heart Button (Top Right) -->
        <button
            class="absolute top-3 right-3 p-2 bg-white rounded-full shadow-md hover:bg-gray-50 transition-colors z-20"
            title="Add to wishlist"
        >
            <svg
                class="w-5 h-5 text-gray-700"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                ></path>
            </svg>
        </button>

        <!-- Product Info -->
        <Link
            :href="route('product.show', product.slug)"
            class="p-4 text-center flex-1 flex flex-col justify-between hover:bg-gray-50/50 transition-colors"
        >
            <h3
                class="text-sm font-medium text-gray-700 mb-2 line-clamp-2 min-h-[2.5rem]"
            >
                {{ product.title }}
            </h3>

            <!-- Price -->
            <div class="flex items-center justify-center gap-2">
                <p class="text-lg font-bold text-gray-900">
                    ₹{{ product.price }}
                </p>
                <p
                    v-if="product.discount > 0"
                    class="text-sm text-gray-400 line-through"
                >
                    ₹{{
                        (product.price / (1 - product.discount / 100)).toFixed(
                            2,
                        )
                    }}
                </p>
                <p
                    v-if="product.discount > 0"
                    class="text-sm font-bold text-red-500"
                >
                    ({{ product.discount }}% OFF)
                </p>
            </div>
        </Link>
    </div>
</template>
