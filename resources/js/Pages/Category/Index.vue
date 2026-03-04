<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import { ref, watch, computed } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ProductCard from "@/Components/ProductCard.vue";
import CategorySidebar from "./Partials/CategorySidebar.vue";
import MobileFilterDrawer from "./Partials/MobileFilterDrawer.vue";
import {
    AdjustmentsHorizontalIcon,
    ChevronDownIcon,
    CheckIcon,
} from "@heroicons/vue/24/outline";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";

const props = defineProps({
    categories: Array,
    selectedCategory: Object,
    products: Array,
    brands: Array,
    priceRanges: Array,
    filterState: Object,
});

const isMobileFilterOpen = ref(false);

const updateFilters = (filters) => {
    router.get(
        route("category.index", props.selectedCategory?.slug),
        {
            ...filters,
        },
        {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        },
    );
};

const toggleBrand = (brandId) => {
    const brands = [...props.filterState.brands];
    const index = brands.indexOf(brandId.toString());
    if (index > -1) {
        brands.splice(index, 1);
    } else {
        brands.push(brandId.toString());
    }
    updateFilters({ ...props.filterState, brands: brands.join(",") });
};

const updatePriceRange = (rangeSlug) => {
    updateFilters({ ...props.filterState, price_range: rangeSlug });
};

const updateSort = (sortBy) => {
    updateFilters({ ...props.filterState, sortBy });
};

const clearFilters = () => {
    updateFilters({ sortBy: props.filterState.sortBy });
};

const sortOptions = [
    { value: "newest", label: "Newest First" },
    { value: "price_low_high", label: "Price: Low to High" },
    { value: "price_high_low", label: "Price: High to Low" },
];

const currentSortLabel = computed(() => {
    const current = sortOptions.find(
        (opt) => opt.value === props.filterState.sortBy,
    );
    // If the current sortBy is empty or doesn't match a label, show 'Sort By'
    if (!props.filterState.sortBy || props.filterState.sortBy === 'newest') {
        return "Sort By";
    }
    return current ? current.label : "Sort By";
});
</script>

<template>
    <Head :title="selectedCategory ? selectedCategory.title : 'Categories'" />

    <AuthenticatedLayout>
        <!-- Compact Hero Section (Synced with Contact Us) -->
        <div class="relative bg-gray-900 py-12 md:py-20 overflow-hidden">
            <!-- Decorative Elements -->
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
                        <li class="flex items-center space-x-3">
                            <span class="text-gray-800">/</span>
                            <span
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-primary"
                                >{{ selectedCategory ? selectedCategory.title : 'All Categories' }}</span
                            >
                        </li>
                    </ol>
                </nav>

                <div class="space-y-4">
                    <h1
                        class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-3"
                    >
                        Premium Collection
                    </h1>
                    <h2 class="text-3xl md:text-4xl font-black mb-4">
                        {{ selectedCategory ? selectedCategory.title : 'All Categories' }}
                        <span class="text-primary italic">Collection</span>
                    </h2>
                    <p
                        class="text-gray-400 text-base md:text-lg max-w-xl mx-auto leading-relaxed opacity-80"
                    >
                        Explore our curated selection of
                        {{ selectedCategory ? selectedCategory.title.toLowerCase() : 'all premium cards' }} designed for
                        every special occasion.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 py-12">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Desktop Sidebar -->
                    <aside class="w-full lg:w-80 flex-shrink-0">
                        <CategorySidebar
                            :categories="categories"
                            :selectedCategory="selectedCategory"
                            :brands="brands"
                            :priceRanges="priceRanges"
                            :filterState="filterState"
                            @toggleBrand="toggleBrand"
                            @updatePriceRange="updatePriceRange"
                        />
                    </aside>

                    <!-- Main Content -->
                    <main class="flex-1">
                        <!-- Toolbar -->
                        <div
                            class="mb-6 lg:mb-8 bg-white p-4 sm:p-6 rounded-[1.5rem] lg:rounded-[2rem] shadow-sm border border-gray-100"
                        >
                            <div
                                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                            >
                                <!-- Results Text -->
                                <div
                                    class="order-2 sm:order-1 flex items-center justify-center sm:justify-start"
                                >
                                    <span
                                        class="text-xs sm:text-sm font-bold text-gray-500"
                                    >
                                        Showing
                                        <span class="text-gray-900">{{
                                            products.length
                                        }}</span>
                                        Results
                                    </span>
                                </div>

                                <!-- Mobile: Grid 2 cols for buttons. Desktop: Flex row -->
                                <div
                                    class="order-1 sm:order-2 w-full sm:w-auto grid grid-cols-2 sm:flex sm:items-center gap-3 sm:gap-4"
                                >
                                    <button
                                        @click="isMobileFilterOpen = true"
                                        class="lg:hidden w-full sm:w-auto flex items-center justify-center gap-1.5 sm:gap-2 px-3 sm:px-6 py-3.5 bg-gray-900 text-white rounded-xl sm:rounded-2xl text-[10px] sm:text-xs font-black uppercase tracking-widest active:scale-95 transition-all shadow-xl shadow-gray-200"
                                    >
                                        <AdjustmentsHorizontalIcon
                                            class="w-4 h-4 sm:w-4 sm:h-4"
                                        />
                                        Filters
                                    </button>

                                    <!-- Professional Sorting Dropdown using Headless UI -->
                                    <Menu
                                        as="div"
                                        class="relative inline-block text-left w-full sm:w-auto"
                                    >
                                        <div>
                                            <MenuButton
                                                class="inline-flex w-full sm:w-64 justify-between items-center gap-x-1.5 rounded-xl sm:rounded-2xl bg-gray-50 px-4 sm:px-6 py-3.5 text-xs sm:text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-200 hover:bg-gray-100 transition-all focus:outline-none focus:ring-2 focus:ring-primary/20"
                                            >
                                                {{ currentSortLabel }}
                                                <ChevronDownIcon
                                                    class="-mr-1 h-4 w-4 text-gray-400"
                                                    aria-hidden="true"
                                                />
                                            </MenuButton>
                                        </div>

                                        <transition
                                            enter-active-class="transition ease-out duration-100"
                                            enter-from-class="transform opacity-0 scale-95"
                                            enter-to-class="transform opacity-100 scale-100"
                                            leave-active-class="transition ease-in duration-75"
                                            leave-from-class="transform opacity-100 scale-100"
                                            leave-to-class="transform opacity-0 scale-95"
                                        >
                                            <MenuItems
                                                class="absolute right-0 z-50 mt-2 w-full origin-top-right rounded-2xl bg-white shadow-xl ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden"
                                            >
                                                <div class="py-1">
                                                    <MenuItem
                                                        v-for="option in sortOptions"
                                                        :key="option.value"
                                                        v-slot="{ active }"
                                                    >
                                                        <button
                                                            @click="
                                                                updateSort(
                                                                    option.value,
                                                                )
                                                            "
                                                            :class="[
                                                                active
                                                                    ? 'bg-primary/5 text-primary'
                                                                    : 'text-gray-700',
                                                                option.value ===
                                                                filterState.sortBy
                                                                    ? 'bg-primary/10 font-black text-primary'
                                                                    : 'font-medium',
                                                                'group flex w-full items-center justify-between px-4 py-3 text-sm transition-colors',
                                                            ]"
                                                        >
                                                            {{ option.label }}
                                                            <CheckIcon
                                                                v-if="
                                                                    option.value ===
                                                                    filterState.sortBy
                                                                "
                                                                class="h-4 w-4 text-primary"
                                                                aria-hidden="true"
                                                            />
                                                        </button>
                                                    </MenuItem>
                                                </div>
                                            </MenuItems>
                                        </transition>
                                    </Menu>
                                </div>
                            </div>
                        </div>

                        <!-- Product Grid -->
                        <div
                            v-if="products.length > 0"
                            class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6"
                        >
                            <div
                                v-for="product in products"
                                :key="product.id"
                                class="animate-fade-in"
                            >
                                <ProductCard :product="product" />
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div
                            v-else
                            class="bg-white rounded-[3rem] p-16 text-center border border-gray-100 shadow-sm"
                        >
                            <div
                                class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-8"
                            >
                                <AdjustmentsHorizontalIcon
                                    class="w-10 h-10 text-gray-300"
                                />
                            </div>
                            <h3
                                class="text-2xl font-black text-gray-900 mb-4 tracking-tight"
                            >
                                No matching products
                            </h3>
                            <p class="text-gray-500 max-w-sm mx-auto mb-10">
                                We couldn't find any products matching your
                                current filter selection.
                            </p>
                            <button
                                @click="clearFilters"
                                class="px-8 py-4 bg-primary text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-gray-900 transition-all active:scale-95 shadow-xl shadow-primary/20"
                            >
                                Clear All Filters
                            </button>
                        </div>
                    </main>
                </div>
            </div>
        </div>

        <!-- Mobile Filter Drawer -->
        <MobileFilterDrawer
            :isOpen="isMobileFilterOpen"
            :categories="categories"
            :selectedCategory="selectedCategory"
            :brands="brands"
            :priceRanges="priceRanges"
            :filterState="filterState"
            @close="isMobileFilterOpen = false"
            @toggleBrand="toggleBrand"
            @updatePriceRange="updatePriceRange"
            @clearFilters="clearFilters"
        />
    </AuthenticatedLayout>
</template>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

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
