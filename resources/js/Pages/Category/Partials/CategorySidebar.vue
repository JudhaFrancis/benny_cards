<script setup>
import { Link } from "@inertiajs/vue3";
import {
    QueueListIcon,
    Squares2X2Icon,
    CheckIcon,
    AdjustmentsHorizontalIcon,
} from "@heroicons/vue/20/solid";
import { StarIcon } from "@heroicons/vue/24/outline";
import { StarIcon as StarIconSolid } from "@heroicons/vue/24/solid";

const props = defineProps({
    categories: Array,
    selectedCategory: Object,
    brands: Array,
    priceRanges: Array,
    filterState: Object,
});

const emit = defineEmits(["toggleBrand", "updatePriceRange", "updateRating"]);
</script>

<template>
    <div class="hidden lg:block sticky top-28 space-y-8">
        <!-- Category Navigation Card -->
        <div
            class="bg-white/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-white/40 overflow-hidden"
        >
            <div class="p-8">
                <h3
                    class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3"
                >
                    <QueueListIcon class="w-4 h-4 text-primary" />
                    Collections
                </h3>
                <nav class="space-y-1">
                    <Link
                        :href="route('category.index')"
                        class="flex items-center justify-between group px-4 py-3 rounded-2xl transition-all duration-300"
                        :class="
                            !selectedCategory
                                ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-[1.02]'
                                : 'text-gray-600 hover:bg-primary/5 hover:text-primary hover:translate-x-1'
                        "
                    >
                        <span class="text-sm font-bold">All Categories</span>
                        <span
                            class="text-[9px] font-black px-2 py-0.5 rounded-full transition-colors"
                            :class="
                                !selectedCategory
                                    ? 'bg-white/20 text-white'
                                    : 'bg-gray-100 text-gray-400 group-hover:bg-primary/10 group-hover:text-primary'
                            "
                        >
                            {{ categories.reduce((total, cat) => total + cat.products_count, 0) }}
                        </span>
                    </Link>

                    <Link
                        v-for="category in categories"
                        :key="category.id"
                        :href="route('category.index', category.slug)"
                        class="flex items-center justify-between group px-4 py-3 rounded-2xl transition-all duration-300"
                        :class="
                            selectedCategory?.id === category.id
                                ? 'bg-primary text-white shadow-xl shadow-primary/20 scale-[1.02]'
                                : 'text-gray-600 hover:bg-primary/5 hover:text-primary hover:translate-x-1'
                        "
                    >
                        <span class="text-sm font-bold">{{
                            category.title
                        }}</span>
                        <span
                            class="text-[9px] font-black px-2 py-0.5 rounded-full transition-colors"
                            :class="
                                selectedCategory?.id === category.id
                                    ? 'bg-white/20 text-white'
                                    : 'bg-gray-100 text-gray-400 group-hover:bg-primary/10 group-hover:text-primary'
                            "
                        >
                            {{ category.products_count }}
                        </span>
                    </Link>
                </nav>
            </div>
        </div>

        <!-- Filter Controls Panel -->
        <div
            class="bg-white/70 backdrop-blur-xl rounded-[2rem] shadow-sm border border-white/40 overflow-hidden divide-y divide-gray-100/50"
        >
            <!-- Brands Section -->
            <div class="p-8" v-if="brands.length > 0">
                <h3
                    class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3"
                >
                    <Squares2X2Icon class="w-4 h-4 text-primary" />
                    Brands
                </h3>
                <div class="space-y-4">
                    <label
                        v-for="brand in brands"
                        :key="brand.id"
                        class="flex items-center group cursor-pointer relative"
                    >
                        <div
                            class="relative w-5 h-5 flex items-center justify-center"
                        >
                            <input
                                type="checkbox"
                                :checked="
                                    filterState.brands.includes(
                                        brand.id.toString(),
                                    )
                                "
                                @change="emit('toggleBrand', brand.id)"
                                class="peer absolute opacity-0 cursor-pointer w-full h-full z-10"
                            />
                            <div
                                class="w-5 h-5 bg-white border-2 border-gray-100 rounded-lg transition-all duration-300 peer-checked:bg-primary peer-checked:border-primary peer-checked:shadow-primary/30 peer-checked:shadow-lg flex items-center justify-center"
                            >
                                <CheckIcon
                                    class="w-3.5 h-3.5 text-white scale-0 transition-transform duration-300 peer-checked:scale-110"
                                />
                            </div>
                        </div>
                        <span
                            class="ml-4 text-sm font-bold text-gray-500 group-hover:text-gray-900 transition-colors"
                            >{{ brand.title }}</span
                        >
                    </label>
                </div>
            </div>

            <!-- Price Range Section -->
            <div class="p-8">
                <h3
                    class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3"
                >
                    <AdjustmentsHorizontalIcon class="w-4 h-4 text-primary" />
                    Price Spectrum
                </h3>
                <div class="space-y-4">
                    <label class="flex items-center group cursor-pointer">
                        <div class="relative flex items-center">
                            <input
                                type="radio"
                                :checked="filterState.price_range === ''"
                                @change="emit('updatePriceRange', '')"
                                class="peer absolute opacity-0 w-full h-full z-10 cursor-pointer"
                            />
                            <div
                                class="w-5 h-5 bg-white border-2 border-gray-100 rounded-full transition-all duration-300 peer-checked:border-primary peer-checked:border-[6px] group-hover:border-primary/30"
                            ></div>
                        </div>
                        <span
                            class="ml-4 text-sm font-bold text-gray-500 group-hover:text-gray-900 transition-colors"
                            >Everything</span
                        >
                    </label>
                    <label
                        v-for="range in priceRanges"
                        :key="range.id"
                        class="flex items-center group cursor-pointer"
                    >
                        <div class="relative flex items-center">
                            <input
                                type="radio"
                                :checked="
                                    filterState.price_range === range.slug
                                "
                                @change="emit('updatePriceRange', range.slug)"
                                class="peer absolute opacity-0 w-full h-full z-10 cursor-pointer"
                            />
                            <div
                                class="w-5 h-5 bg-white border-2 border-gray-100 rounded-full transition-all duration-300 peer-checked:border-primary peer-checked:border-[6px] group-hover:border-primary/30"
                            ></div>
                        </div>
                        <span
                            class="ml-4 text-sm font-bold text-gray-500 group-hover:text-gray-900 transition-colors"
                            >{{ range.title }}</span
                        >
                    </label>
                </div>
            </div>

            <!-- Rating Section -->
            <div class="p-8">
                <h3
                    class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3"
                >
                    <StarIcon class="w-4 h-4 text-primary" />
                    Min. Rating
                </h3>
                <div class="space-y-4">
                    <label
                        v-for="rate in [4, 3, 2, 1]"
                        :key="rate"
                        class="flex items-center group cursor-pointer"
                    >
                        <div class="relative flex items-center">
                            <input
                                type="radio"
                                :checked="filterState.rating === rate"
                                @change="emit('updateRating', rate)"
                                class="peer absolute opacity-0 w-full h-full z-10 cursor-pointer"
                            />
                            <div
                                class="w-5 h-5 bg-white border-2 border-gray-100 rounded-full transition-all duration-300 peer-checked:border-primary peer-checked:border-[6px] group-hover:border-primary/30"
                            ></div>
                        </div>
                        <div class="ml-4 flex items-center gap-2">
                            <span
                                class="text-sm font-bold text-gray-500 group-hover:text-gray-900 transition-colors"
                                >{{ rate }}+</span
                            >
                            <div class="flex items-center gap-0.5">
                                <StarIconSolid
                                    v-for="i in 5"
                                    :key="i"
                                    class="w-3 h-3"
                                    :class="
                                        i <= rate
                                            ? 'text-yellow-400'
                                            : 'text-gray-200'
                                    "
                                />
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>
