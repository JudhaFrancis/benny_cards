<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProductCard from "@/Components/ProductCard.vue";

const props = defineProps({
    wishlist: {
        type: Array,
        required: true,
    },
});

const removeFromWishlist = (id) => {
    router.delete(route("wishlist.destroy", id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="My Wishlist">
        <link
            v-if="$page.props.settings?.logo"
            rel="icon"
            :href="$page.props.settings.logo"
        />
    </Head>

    <AuthenticatedLayout :transparent-header="false">
        <!-- Compact Hero Section (Synced with My Orders Design) -->
        <div class="relative bg-gray-900 py-12 md:py-16 overflow-hidden">
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
                <nav
                    class="flex justify-center mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gray-500"
                    aria-label="Breadcrumb"
                >
                    <ol class="flex items-center space-x-2">
                        <li>
                            <Link
                                :href="route('home')"
                                class="hover:text-primary transition-colors"
                                >Home</Link
                            >
                        </li>
                        <li>
                            <div class="flex items-center space-x-2">
                                <svg
                                    class="w-2.5 h-2.5 text-gray-700"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="3"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                                <span class="text-gray-400">My Wishlist</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-2xl md:text-3xl font-black text-white px-4">
                    My Wishlist
                </h1>
            </div>
        </div>

        <div class="py-12 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Content -->
                <div v-if="wishlist.length > 0">
                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8"
                    >
                        <div
                            v-for="item in wishlist"
                            :key="item.id"
                            class="relative group"
                        >
                            <ProductCard :product="item.product" />

                            <!-- Remove Overlay for Index Page -->
                            <button
                                @click="removeFromWishlist(item.id)"
                                class="absolute top-4 left-4 z-30 p-2 bg-red-500 text-white rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 transform hover:scale-110"
                                title="Remove from wishlist"
                            >
                                <svg
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div
                    v-else
                    class="bg-white rounded-[2.5rem] p-12 text-center border border-gray-100 shadow-xl shadow-gray-200/50"
                >
                    <div
                        class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6"
                    >
                        <svg
                            class="w-10 h-10 text-gray-300"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                            />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 mb-4">
                        Your wishlist is empty
                    </h2>
                    <p class="text-gray-500 mb-8 max-w-sm mx-auto">
                        Explore our collection of premium cards and gifts to
                        find something you love.
                    </p>
                    <Link
                        :href="route('home')"
                        class="inline-flex items-center justify-center rounded-xl bg-primary px-8 py-3 text-sm font-black text-white shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all hover:-translate-y-0.5"
                    >
                        Start Shopping
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
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
