<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    averageRating: {
        type: String,
        default: "0.0",
    },
});

const calculateOriginalPrice = (price, discount) => {
    return (price / (1 - discount / 100)).toFixed(0);
};

const page = usePage();
const quantity = ref(1);

const isInWishlist = computed(() => {
    return page.props.wishlist?.some(
        (item) => item.product_id === props.product.id,
    );
});

const addToWishlist = () => {
    if (!page.props.auth.user) {
        router.visit(route("login"));
        return;
    }

    router.post(
        route("wishlist.store"),
        {
            product_id: props.product.id,
        },
        {
            preserveScroll: true,
        },
    );
};

const addToCart = () => {
    if (!page.props.auth.user) {
        router.visit(route("login"));
        return;
    }

    router.post(
        route("cart.store"),
        {
            product_id: props.product.id,
            quantity: quantity.value,
        },
        {
            preserveScroll: true,
        },
    );
};
</script>

<template>
    <!-- Product info -->
    <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
        <div class="flex items-center justify-between gap-4 mb-4">
            <div
                class="text-[10px] uppercase tracking-wider font-bold px-3 py-1.5 rounded-full shadow-sm border"
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
                v-if="product.condition && product.condition !== 'default'"
                class="text-[10px] uppercase tracking-wider font-bold px-3 py-1.5 rounded-full shadow-sm border"
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
        </div>

        <h1
            class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl mb-4"
        >
            {{ product.title }}
        </h1>

        <div class="mt-6 flex items-baseline gap-4">
            <h2 class="sr-only">Product information</h2>
            <p class="text-2xl font-black text-primary">₹{{ product.price }}</p>
            <p
                v-if="product.discount > 0"
                class="text-lg text-gray-400 line-through"
            >
                ₹{{ calculateOriginalPrice(product.price, product.discount) }}
            </p>
            <span
                v-if="product.discount > 0"
                class="text-sm font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg"
            >
                {{ product.discount }}% OFF
            </span>
        </div>

        <div class="mt-6">
            <h3 class="sr-only">Description</h3>
            <div
                class="text-base text-gray-600 leading-relaxed"
                v-html="product.summary"
            ></div>
        </div>

        <div class="mt-10 flex flex-col sm:flex-row gap-4">
            <!-- Quantity Selector -->
            <div
                class="flex items-center bg-gray-100 rounded-xl p-1 border border-gray-200 w-full sm:w-32"
            >
                <button
                    @click="quantity > 1 ? quantity-- : null"
                    class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white hover:shadow-sm transition-all text-gray-500 font-bold"
                >
                    -
                </button>
                <span class="flex-1 text-center font-black text-sm">{{
                    quantity
                }}</span>
                <button
                    @click="quantity++"
                    class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white hover:shadow-sm transition-all text-gray-500 font-bold"
                >
                    +
                </button>
            </div>

            <button
                @click="addToCart"
                type="button"
                class="flex-1 bg-cyan-400 border border-transparent rounded-xl py-3 px-8 flex items-center justify-center text-base font-bold text-white hover:bg-cyan-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition-all transform hover:scale-[1.01] active:scale-95 shadow-lg shadow-cyan-200"
            >
                <svg
                    class="w-5 h-5 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                    />
                </svg>
                Add to Cart
            </button>

            <button
                @click="addToWishlist"
                type="button"
                class="w-full sm:w-14 bg-white border-2 border-gray-100 rounded-xl py-3 flex items-center justify-center transition-all group shadow-sm"
                :class="{
                    'text-red-500 border-red-100 bg-red-50': isInWishlist,
                    'text-gray-400 hover:text-red-500 hover:border-red-100 hover:bg-red-50':
                        !isInWishlist,
                }"
            >
                <svg
                    class="w-6 h-6"
                    :class="{
                        'fill-current': isInWishlist,
                        'group-hover:fill-current': !isInWishlist,
                    }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    />
                </svg>
                <span class="sr-only">Add to wishlist</span>
            </button>
        </div>
    </div>
</template>
