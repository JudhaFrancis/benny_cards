<script setup>
import { Link } from "@inertiajs/vue3";
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon, CheckIcon, StarIcon } from "@heroicons/vue/24/outline";
import { StarIcon as StarIconSolid } from "@heroicons/vue/24/solid";

defineProps({
    isOpen: Boolean,
    categories: Array,
    selectedCategory: Object,
    brands: Array,
    priceRanges: Array,
    filterState: Object,
});

const emit = defineEmits([
    "close",
    "toggleBrand",
    "clearFilters",
    "updatePriceRange",
    "updateRating",
]);
</script>

<template>
    <TransitionRoot as="template" :show="isOpen">
        <Dialog as="div" class="relative z-50 lg:hidden" @close="emit('close')">
            <TransitionChild
                as="template"
                enter="transition-opacity ease-linear duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-linear duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" />
            </TransitionChild>

            <div class="fixed inset-0 flex">
                <TransitionChild
                    as="template"
                    enter="transition ease-in-out duration-500 transform"
                    enter-from="translate-x-full"
                    enter-to="translate-x-0"
                    leave="transition ease-in-out duration-500 transform"
                    leave-from="translate-x-0"
                    leave-to="translate-x-full"
                >
                    <DialogPanel
                        class="relative ml-auto flex h-full w-full max-w-sm flex-col overflow-y-auto bg-white/80 backdrop-blur-2xl shadow-3xl border-l border-white/20"
                    >
                        <div
                            class="flex items-center justify-between px-6 py-8 border-b border-gray-100/50"
                        >
                            <div class="flex flex-col">
                                <h2
                                    class="text-3xl font-black text-gray-900 tracking-tight leading-none"
                                >
                                    Filters
                                </h2>
                                <span
                                    class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mt-3"
                                >
                                    Refine Selection
                                </span>
                            </div>
                            <button
                                type="button"
                                class="p-3 bg-gray-50 rounded-2xl text-gray-400 hover:text-gray-500 transition-colors"
                                @click="emit('close')"
                            >
                                <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                            </button>
                        </div>

                        <!-- Mobile Filter Content -->
                        <div class="px-6 py-8 space-y-12">
                            <!-- Mobile Categories -->
                            <div>
                                <h3
                                    class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6"
                                >
                                    Collections
                                </h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <Link
                                        :href="route('category.index')"
                                        class="flex items-center gap-3 p-4 rounded-2xl border transition-all duration-300 active:scale-95 shadow-sm"
                                        :class="
                                            !selectedCategory
                                                ? 'bg-primary border-primary text-white shadow-lg shadow-primary/20 ring-4 ring-primary/10'
                                                : 'bg-white/50 border-gray-100 text-gray-600 hover:border-primary/30'
                                        "
                                    >
                                        <span class="text-xs font-black truncate">All</span>
                                    </Link>
                                    <Link
                                        v-for="category in categories"
                                        :key="category.id"
                                        :href="
                                            route(
                                                'category.index',
                                                category.slug,
                                            )
                                        "
                                        class="flex items-center gap-3 p-4 rounded-2xl border transition-all duration-300 active:scale-95 shadow-sm"
                                        :class="
                                            selectedCategory?.id === category.id
                                                ? 'bg-primary border-primary text-white shadow-lg shadow-primary/20 ring-4 ring-primary/10'
                                                : 'bg-white/50 border-gray-100 text-gray-600 hover:border-primary/30'
                                        "
                                    >
                                        <span
                                            class="text-xs font-black truncate"
                                            >{{ category.title }}</span
                                        >
                                    </Link>
                                </div>
                            </div>

                            <!-- Mobile Brands -->
                            <div v-if="brands.length > 0">
                                <h3
                                    class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6"
                                >
                                    Brands
                                </h3>
                                <div class="flex flex-wrap gap-2">
                                    <button
                                        v-for="brand in brands"
                                        :key="brand.id"
                                        @click="emit('toggleBrand', brand.id)"
                                        class="px-5 py-3 rounded-xl text-[11px] font-black uppercase tracking-wider transition-all duration-300 border active:scale-95 shadow-sm"
                                        :class="
                                            filterState.brands.includes(
                                                brand.id.toString(),
                                            )
                                                ? 'bg-gray-900 border-gray-900 text-white shadow-lg shadow-gray-200 ring-4 ring-gray-900/10'
                                                : 'bg-white/50 border-gray-100 text-gray-500 hover:border-gray-900 hover:text-gray-900'
                                        "
                                    >
                                        {{ brand.title }}
                                    </button>
                                </div>
                            </div>

                            <!-- Mobile Price -->
                            <div>
                                <h3
                                    class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6"
                                >
                                    Price Range
                                </h3>
                                <div class="grid grid-cols-1 gap-3">
                                    <button
                                        v-for="range in priceRanges"
                                        :key="range.id"
                                        @click="
                                            emit('updatePriceRange', range.slug)
                                        "
                                        class="px-5 py-4 rounded-2xl border text-left flex items-center justify-between transition-all duration-300 active:scale-[0.98]"
                                        :class="
                                            filterState.price_range ===
                                            range.slug
                                                ? 'bg-primary/5 border-primary text-primary shadow-lg shadow-primary/5 ring-4 ring-primary/10'
                                                : 'bg-white/50 border-gray-100 text-gray-600 shadow-sm'
                                        "
                                    >
                                        <span class="text-sm font-bold">{{
                                            range.title
                                        }}</span>
                                        <div
                                            v-if="
                                                filterState.price_range ===
                                                range.slug
                                            "
                                            class="w-5 h-5 bg-primary text-white rounded-full flex items-center justify-center"
                                        >
                                            <CheckIcon class="w-3 h-3" />
                                        </div>
                                    </button>
                                </div>
                            </div>

                            <!-- Mobile Rating -->
                            <div>
                                <h3
                                    class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6"
                                >
                                    Min. Rating
                                </h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <button
                                        v-for="rate in [4, 3, 2, 1]"
                                        :key="rate"
                                        @click="emit('updateRating', rate)"
                                        class="px-4 py-4 rounded-2xl border flex flex-col items-center gap-2 transition-all duration-300"
                                        :class="
                                            filterState.rating === rate
                                                ? 'bg-yellow-50 border-yellow-400 text-yellow-700 shadow-lg shadow-yellow-100'
                                                : 'bg-white border-gray-100 text-gray-500 shadow-sm'
                                        "
                                    >
                                        <span class="text-sm font-black"
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
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Footer Actions -->
                        <div
                            class="sticky bottom-0 mt-auto p-6 bg-white/80 backdrop-blur-xl border-t border-gray-100/50 flex items-center gap-4"
                        >
                            <button
                                @click="emit('clearFilters')"
                                class="flex-1 px-6 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest text-gray-500 bg-gray-100 hover:bg-gray-200 transition-all active:scale-95"
                            >
                                Reset
                            </button>
                            <button
                                @click="emit('close')"
                                class="flex-[2] px-6 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest text-white bg-primary hover:bg-gray-900 transition-all shadow-xl shadow-primary/20 active:scale-95"
                            >
                                Show Results
                            </button>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
