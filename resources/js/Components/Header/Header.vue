<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import NavLink from "@/Components/Navigation/NavLink.vue";
import ResponsiveNavLink from "@/Components/Navigation/ResponsiveNavLink.vue";
import MobileNavDrawer from "@/Components/Header/MobileNavDrawer.vue";
import LoginModal from "@/Components/Auth/LoginModal.vue";
import { Link, router, usePage } from "@inertiajs/vue3";

const props = defineProps({
    transparentMode: {
        type: Boolean,
        default: false,
    },
});

const page = usePage();
const search = ref(page.props.search || "");
const showingNavigationDropdown = ref(false);
const isScrolled = ref(false);
const isLoginModalOpen = ref(false);
const initialRegister = ref(false);

const openLoginModal = () => {
    initialRegister.value = false;
    isLoginModalOpen.value = true;
};

const openRegisterModal = () => {
    initialRegister.value = true;
    isLoginModalOpen.value = true;
};

// --- Autocomplete ---
const categories = ref([]);
const products = ref([]);
const showSuggestions = ref(false);
const loadingSuggestions = ref(false);
const highlightedIndex = ref(-1);
const searchContainerRef = ref(null);
let debounceTimer = null;

// flat list for keyboard navigation: categories first, then products
const allItems = computed(() => [
    ...categories.value.map((c) => ({ ...c, _type: "category" })),
    ...products.value.map((p) => ({ ...p, _type: "product" })),
]);

const hasResults = computed(() => allItems.value.length > 0);

const fetchSuggestions = async (query) => {
    if (query.length < 2) {
        categories.value = [];
        products.value = [];
        showSuggestions.value = false;
        return;
    }
    loadingSuggestions.value = true;
    try {
        const res = await fetch(
            `/api/search-suggestions?q=${encodeURIComponent(query)}`,
        );
        const data = await res.json();
        categories.value = data.categories || [];
        products.value = data.products || [];
        showSuggestions.value = hasResults.value;
        highlightedIndex.value = -1;
    } catch (e) {
        categories.value = [];
        products.value = [];
        showSuggestions.value = false;
    } finally {
        loadingSuggestions.value = false;
    }
};

watch(search, (val) => {
    clearTimeout(debounceTimer);
    if (!val || val.length < 2) {
        categories.value = [];
        products.value = [];
        showSuggestions.value = false;
        return;
    }
    debounceTimer = setTimeout(() => fetchSuggestions(val), 250);
});

const handleSearch = (e) => {
    showSuggestions.value = false;
    categories.value = [];
    products.value = [];
    router.get(
        route("category.index"),
        { search: search.value },
        { preserveState: true, replace: true },
    );
};

const selectSuggestion = (product) => {
    search.value = product.title;
    showSuggestions.value = false;
    categories.value = [];
    products.value = [];
    router.get(route("product.show", product.slug));
};

const selectCategory = (category) => {
    search.value = "";
    showSuggestions.value = false;
    categories.value = [];
    products.value = [];
    router.get(route("category.index", category.slug));
};

const onArrowDown = () => {
    if (highlightedIndex.value < allItems.value.length - 1) {
        highlightedIndex.value++;
    }
};

const onArrowUp = () => {
    if (highlightedIndex.value > 0) {
        highlightedIndex.value--;
    }
};

const onEnter = () => {
    const item = allItems.value[highlightedIndex.value];
    if (item) {
        if (item._type === "category") {
            selectCategory(item);
        } else {
            selectSuggestion(item);
        }
    } else {
        handleSearch();
    }
};

const closeSuggestions = () => {
    showSuggestions.value = false;
};

const handleClickOutside = (e) => {
    if (
        searchContainerRef.value &&
        !searchContainerRef.value.contains(e.target)
    ) {
        closeSuggestions();
    }
};

// Sync search ref with page props when they change
watch(
    () => page.props.search,
    (newSearch) => {
        search.value = newSearch || "";
    },
);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    document.addEventListener("click", handleClickOutside);

    // Check for login/register query params
    const params = new URLSearchParams(window.location.search);
    if (params.get("login") === "1") {
        openLoginModal();
    } else if (params.get("register") === "1") {
        openRegisterModal();
    }
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
    document.removeEventListener("click", handleClickOutside);
    clearTimeout(debounceTimer);
});

const navClasses = computed(() => {
    const baseClasses =
        "sticky top-0 w-full z-50 transition-all duration-300 bg-white";
    return isScrolled.value
        ? `${baseClasses} border-b border-gray-100 shadow-sm`
        : `${baseClasses} border-transparent`;
});

const textClasses = computed(() => {
    return "text-gray-600 hover:text-primary";
});

const navLinkInactiveClasses = computed(() => {
    return "text-gray-600 hover:text-gray-900 hover:bg-gray-100/50";
});

const searchContainerClasses = computed(() => {
    return "bg-gray-100/50 border-transparent text-gray-700 placeholder-gray-400 focus-within:bg-white focus-within:shadow-md ring-primary/10";
});

const searchInputClasses = computed(() => {
    return "text-gray-700 placeholder-gray-400 focus:ring-primary/10";
});

const logoClasses = computed(() => {
    return "text-gray-800";
});

const removeFromWishlist = (id) => {
    router.delete(route("wishlist.destroy", id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <nav :class="navClasses">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 justify-between items-center">
                <!-- Logo and Nav Links -->
                <div class="flex items-center">
                    <div class="flex shrink-0 items-center">
                        <Link href="/">
                            <img
                                v-if="$page.props.settings?.logo"
                                :src="$page.props.settings.logo"
                                alt="Logo"
                                class="block h-16 w-auto"
                            />
                            <ApplicationLogo
                                v-else
                                class="block h-16 w-auto fill-current transition-colors duration-300"
                                :class="logoClasses"
                            />
                        </Link>
                    </div>

                    <div
                        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center"
                    >
                        <NavLink
                            href="/"
                            :active="$page.url === '/'"
                            :inactive-class="navLinkInactiveClasses"
                        >
                            Home
                        </NavLink>
                        <NavLink
                            :href="route('about')"
                            :active="route().current('about')"
                            :inactive-class="navLinkInactiveClasses"
                        >
                            About Us
                        </NavLink>
                        <Dropdown
                            align="header-center"
                            width="4xl"
                            mode="hover"
                            :content-classes="'py-1 bg-white overflow-hidden'"
                        >
                            <template #trigger>
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-full transition-all duration-200 ease-in-out"
                                    :class="navLinkInactiveClasses"
                                >
                                    Categories
                                    <svg
                                        class="-mr-0.5 ml-2 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </template>

                            <template #content>
                                <div
                                    class="grid grid-cols-3 gap-2 p-4"
                                    v-if="
                                        $page.props.categories &&
                                        $page.props.categories.length
                                    "
                                >
                                    <DropdownLink
                                        v-for="category in $page.props
                                            .categories"
                                        :key="category.id"
                                        :href="'/category/' + category.slug"
                                        class="!w-auto rounded-lg hover:bg-gray-50 transition-colors"
                                    >
                                        {{ category.title }}
                                    </DropdownLink>
                                </div>
                                <div
                                    v-else
                                    class="px-4 py-2 text-sm text-gray-500"
                                >
                                    No categories found.
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Search Bar -->
                <div
                    class="hidden sm:flex flex-1 justify-center px-6"
                    ref="searchContainerRef"
                >
                    <div class="relative w-full max-w-lg">
                        <!-- Input pill -->
                        <div
                            class="relative group rounded-full transition-all duration-300"
                            :class="[
                                searchContainerClasses,
                                showSuggestions
                                    ? 'rounded-b-none shadow-md bg-white'
                                    : '',
                            ]"
                        >
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none"
                            >
                                <svg
                                    v-if="!loadingSuggestions"
                                    class="w-5 h-5 transition-colors duration-300"
                                    :class="textClasses"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                                    />
                                </svg>
                                <!-- Loading spinner -->
                                <svg
                                    v-else
                                    class="w-5 h-5 animate-spin text-primary"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    />
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8v8H4z"
                                    />
                                </svg>
                            </div>
                            <input
                                v-model="search"
                                @keyup.enter="onEnter"
                                @keydown.down.prevent="onArrowDown"
                                @keydown.up.prevent="onArrowUp"
                                @keydown.escape="closeSuggestions"
                                @focus="
                                    search.length >= 2 &&
                                    suggestions.length > 0 &&
                                    (showSuggestions = true)
                                "
                                type="text"
                                autocomplete="off"
                                class="block w-full rounded-full border-0 py-2.5 pl-12 pr-4 text-sm focus:ring-2 focus:shadow-lg transition-all duration-300 ease-out bg-transparent"
                                :class="[searchInputClasses, textClasses]"
                                placeholder="Search for products..."
                            />
                        </div>

                        <!-- Suggestions Dropdown -->
                        <Transition
                            enter-active-class="transition ease-out duration-150"
                            enter-from-class="opacity-0 -translate-y-1"
                            enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition ease-in duration-100"
                            leave-from-class="opacity-100 translate-y-0"
                            leave-to-class="opacity-0 -translate-y-1"
                        >
                            <div
                                v-if="showSuggestions"
                                class="absolute left-0 right-0 top-full bg-white border border-t-0 border-gray-100 rounded-b-2xl shadow-xl z-50 overflow-hidden"
                            >
                                <!-- Categories Section -->
                                <div v-if="categories.length > 0">
                                    <div
                                        class="px-4 pt-3 pb-1 text-[10px] font-black uppercase tracking-widest text-gray-400"
                                    >
                                        Categories
                                    </div>
                                    <ul>
                                        <li
                                            v-for="(
                                                category, idx
                                            ) in categories"
                                            :key="'cat-' + category.id"
                                            @mousedown.prevent="
                                                selectCategory(category)
                                            "
                                            class="flex items-center gap-3 px-4 py-2.5 cursor-pointer transition-colors duration-100"
                                            :class="{
                                                'bg-primary/5':
                                                    idx === highlightedIndex,
                                                'hover:bg-gray-50':
                                                    idx !== highlightedIndex,
                                            }"
                                        >
                                            <!-- Category icon/photo -->
                                            <div
                                                class="w-8 h-8 rounded-lg overflow-hidden flex-shrink-0 bg-primary/10 flex items-center justify-center"
                                            >
                                                <img
                                                    v-if="category.photo"
                                                    :src="category.photo"
                                                    :alt="category.title"
                                                    class="w-full h-full object-cover"
                                                />
                                                <svg
                                                    v-else
                                                    class="w-4 h-4 text-primary"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                                                    />
                                                </svg>
                                            </div>
                                            <span
                                                class="text-sm font-semibold text-gray-700 flex-1 truncate"
                                                >{{ category.title }}</span
                                            >
                                            <span
                                                class="text-[10px] font-bold bg-primary/10 text-primary px-2 py-0.5 rounded-full"
                                                >Category</span
                                            >
                                        </li>
                                    </ul>
                                </div>

                                <!-- Divider between sections -->
                                <div
                                    v-if="
                                        categories.length > 0 &&
                                        products.length > 0
                                    "
                                    class="border-t border-gray-100 mx-4"
                                ></div>

                                <!-- Products Section -->
                                <div v-if="products.length > 0">
                                    <div
                                        class="px-4 pt-3 pb-1 text-[10px] font-black uppercase tracking-widest text-gray-400"
                                    >
                                        Products
                                    </div>
                                    <ul>
                                        <li
                                            v-for="(product, idx) in products"
                                            :key="'prod-' + product.id"
                                            @mousedown.prevent="
                                                selectSuggestion(product)
                                            "
                                            class="flex items-center gap-3 px-4 py-2.5 cursor-pointer transition-colors duration-100"
                                            :class="{
                                                'bg-primary/5':
                                                    categories.length + idx ===
                                                    highlightedIndex,
                                                'hover:bg-gray-50':
                                                    categories.length + idx !==
                                                    highlightedIndex,
                                            }"
                                        >
                                            <!-- Product thumbnail -->
                                            <div
                                                class="w-8 h-8 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100"
                                            >
                                                <img
                                                    v-if="product.photo"
                                                    :src="product.photo"
                                                    :alt="product.title"
                                                    class="w-full h-full object-cover"
                                                />
                                                <div
                                                    v-else
                                                    class="w-full h-full flex items-center justify-center"
                                                >
                                                    <svg
                                                        class="w-4 h-4 text-gray-300"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                                        />
                                                    </svg>
                                                </div>
                                            </div>
                                            <!-- Product info -->
                                            <div class="flex-1 min-w-0">
                                                <p
                                                    class="text-sm font-semibold text-gray-800 truncate"
                                                >
                                                    {{ product.title }}
                                                </p>
                                                <p
                                                    v-if="product.price"
                                                    class="text-xs text-primary font-bold mt-0.5"
                                                >
                                                    ₹{{ product.price }}
                                                </p>
                                            </div>
                                            <svg
                                                class="w-4 h-4 text-gray-300 flex-shrink-0"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9 5l7 7-7 7"
                                                />
                                            </svg>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Footer: View all results -->
                                <div
                                    @mousedown.prevent="handleSearch"
                                    class="border-t border-gray-100 px-4 py-3 text-xs font-bold text-center text-primary hover:bg-primary/5 cursor-pointer transition-colors"
                                >
                                    View all results for "{{ search }}"
                                </div>
                            </div>
                        </Transition>
                    </div>
                </div>

                <!-- Right Side Icons -->
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-6">
                    <!-- Wishlist Dropdown -->
                    <!-- Wishlist Link -->
                    <Link
                        :href="route('wishlist.index')"
                        class="group relative flex items-center justify-center h-10 w-10 rounded-full transition-all duration-200 ease-out hover:bg-white/10 focus:outline-none"
                        :class="textClasses"
                    >
                        <span class="sr-only">Wishlist</span>
                        <svg
                            class="h-6 w-6 transform group-hover:scale-110 transition-transform duration-200"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                            ></path>
                        </svg>
                        <span
                            v-if="$page.props.wishlist?.length > 0"
                            class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white shadow-sm ring-2 ring-white"
                        >
                            {{ $page.props.wishlist.length }}
                        </span>
                    </Link>

                    <!-- Cart Icon -->
                    <Link
                        :href="route('cart.index')"
                        class="group relative flex items-center justify-center h-10 w-10 rounded-full transition-all duration-200 ease-out hover:bg-white/10"
                        :class="textClasses"
                    >
                        <span class="sr-only">Cart</span>
                        <svg
                            class="h-6 w-6 transform group-hover:scale-110 transition-transform duration-200"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                            ></path>
                        </svg>
                        <span
                            v-if="$page.props.cart_count > 0"
                            class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-primary text-[10px] font-bold text-white shadow-sm ring-2 ring-white"
                        >
                            {{ $page.props.cart_count }}
                        </span>
                    </Link>

                    <!-- Profile Icon / Dropdown -->
                    <div class="relative" v-if="$page.props.auth.user">
                        <Dropdown align="right" width="56" mode="hover">
                            <template #trigger>
                                <button
                                    type="button"
                                    class="flex items-center justify-center h-10 w-10 rounded-full focus:outline-none transition-all duration-200 hover:bg-white/10"
                                    :class="textClasses"
                                >
                                    <span class="sr-only">Open user menu</span>
                                    <svg
                                        class="h-6 w-6 transform hover:scale-110 transition-transform duration-200"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                                        ></path>
                                    </svg>
                                </button>
                            </template>

                            <template #content>
                                <!-- User Header Area -->
                                <div
                                    class="px-6 py-5 border-b border-gray-100/80 bg-gray-50/50"
                                >
                                    <div class="flex items-center gap-4">
                                        <!-- Header Logo in Dropdown -->
                                        <div
                                            class="h-10 w-10 flex-shrink-0 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center p-1.5"
                                        >
                                            <img
                                                v-if="
                                                    $page.props.settings?.logo
                                                "
                                                :src="$page.props.settings.logo"
                                                alt="Logo"
                                                class="w-full h-full object-contain"
                                            />
                                            <ApplicationLogo
                                                v-else
                                                class="w-full h-full object-contain"
                                            />
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p
                                                class="text-sm font-black text-gray-900 truncate"
                                            >
                                                {{ $page.props.auth.user.name }}
                                            </p>
                                            <p
                                                class="text-xs font-semibold text-gray-500 truncate mt-0.5"
                                                v-if="
                                                    $page.props.auth.user.email
                                                "
                                            >
                                                {{
                                                    $page.props.auth.user.email
                                                }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Links Area -->
                                <div class="py-2">
                                    <!-- My Orders -->
                                    <DropdownLink
                                        :href="route('orders.index')"
                                        class="group flex items-center gap-3 px-6 py-2.5 hover:bg-gray-50"
                                    >
                                        <svg
                                            class="h-5 w-5 text-gray-400 group-hover:text-primary transition-colors"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                                            />
                                        </svg>
                                        <span
                                            class="text-sm font-semibold text-gray-700 group-hover:text-primary transition-colors"
                                            >My Orders</span
                                        >
                                    </DropdownLink>
                                    <!-- Account Info -->
                                    <DropdownLink
                                        :href="route('profile.edit')"
                                        class="group flex items-center gap-3 px-6 py-2.5 hover:bg-gray-50"
                                    >
                                        <svg
                                            class="h-5 w-5 text-gray-400 group-hover:text-primary transition-colors"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                                            />
                                        </svg>
                                        <span
                                            class="text-sm font-semibold text-gray-700 group-hover:text-primary transition-colors"
                                            >Account Info</span
                                        >
                                    </DropdownLink>
                                </div>

                                <!-- Logout Area -->
                                <div class="border-t border-gray-100 py-2">
                                    <DropdownLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="group flex items-center gap-3 px-6 py-2.5 w-full text-left"
                                    >
                                        <svg
                                            class="h-5 w-5 text-gray-400 group-hover:text-red-600 transition-colors"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"
                                            />
                                        </svg>
                                        <span
                                            class="text-sm font-semibold text-gray-700 group-hover:text-red-700 transition-colors"
                                            >Logout</span
                                        >
                                    </DropdownLink>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                    <div class="relative" v-else>
                        <Dropdown
                            align="right"
                            width="64"
                            mode="hover"
                            content-classes="bg-white overflow-hidden shadow-xl border border-gray-100/50"
                        >
                            <template #trigger>
                                <button
                                    type="button"
                                    class="flex items-center justify-center h-10 w-10 rounded-full focus:outline-none transition-all duration-200 hover:bg-white/10"
                                    :class="textClasses"
                                >
                                    <span class="sr-only">Guest menu</span>
                                    <svg
                                        class="h-6 w-6 transform hover:scale-110 transition-transform duration-200"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"
                                        ></path>
                                    </svg>
                                </button>
                            </template>

                            <template #content>
                                <div class="p-7 text-center">
                                    <p
                                        class="text-lg font-bold text-gray-900 mb-2 p-4"
                                    >
                                        Welcome to Benny Cards
                                    </p>
                                    <p
                                        class="text-xs text-gray-500 mb-8 leading-relaxed"
                                    >
                                        Sign in to access your account, track
                                        orders & more.
                                    </p>
                                    <button
                                        @click="openLoginModal"
                                        class="flex w-full justify-center rounded-xl bg-primary px-4 py-3 text-sm font-bold text-white shadow-md hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all mb-6 transform hover:-translate-y-0.5"
                                    >
                                        Log In
                                    </button>
                                    <div
                                        class="text-xs text-gray-500 font-medium pt-4 border-t border-gray-100"
                                    >
                                        New customer?
                                        <button
                                            @click="openRegisterModal"
                                            class="font-bold text-primary hover:text-primary/80 transition-colors ml-1"
                                        >
                                            Sign Up
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button
                        @click="showingNavigationDropdown = true"
                        class="inline-flex items-center justify-center rounded-xl p-3 bg-gray-50 text-gray-400 hover:text-gray-900 transition-all active:scale-95 focus:outline-none"
                    >
                        <svg
                            class="h-6 w-6"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <MobileNavDrawer
            :is-open="showingNavigationDropdown"
            :categories="$page.props.categories"
            @close="showingNavigationDropdown = false"
        />

        <LoginModal
            :is-open="isLoginModalOpen"
            :initial-register="initialRegister"
            @close="isLoginModalOpen = false"
        />
    </nav>
</template>
