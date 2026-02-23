<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown/Dropdown.vue";
import DropdownLink from "@/Components/Dropdown/DropdownLink.vue";
import NavLink from "@/Components/Navigation/NavLink.vue";
import ResponsiveNavLink from "@/Components/Navigation/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    transparentMode: {
        type: Boolean,
        default: false,
    },
});

const showingNavigationDropdown = ref(false);
const isScrolled = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

const navClasses = computed(() => {
    const baseClasses =
        "sticky top-0 w-full z-50 transition-all duration-300 bg-white";
    return isScrolled.value
        ? `${baseClasses} border-b border-gray-100 shadow-sm`
        : `${baseClasses} border-transparent`;
});

const textClasses = computed(() => {
    // Always use dark text since we have a light pill background
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
                            href="#"
                            :active="false"
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
                <div class="hidden sm:flex flex-1 justify-center px-6">
                    <div
                        class="relative w-full max-w-lg group rounded-full transition-all duration-300"
                        :class="searchContainerClasses"
                    >
                        <div
                            class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none"
                        >
                            <svg
                                class="w-5 h-5 transition-colors duration-300"
                                :class="textClasses"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                                ></path>
                            </svg>
                        </div>
                        <input
                            type="text"
                            class="block w-full rounded-full border-0 py-2.5 pl-12 pr-4 text-sm focus:ring-2 focus:shadow-lg transition-all duration-300 ease-out bg-transparent"
                            :class="[searchInputClasses, textClasses]"
                            placeholder="Search for products..."
                        />
                    </div>
                </div>

                <!-- Right Side Icons -->
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-6">
                    <!-- Wishlist Icon -->
                    <Link
                        href="#"
                        class="group relative flex items-center justify-center h-10 w-10 rounded-full transition-all duration-200 ease-out hover:bg-white/10"
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
                        <span class="absolute top-2 right-2 flex h-2.5 w-2.5">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"
                            ></span>
                            <span
                                class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 ring-2 ring-white"
                            ></span>
                        </span>
                    </Link>

                    <!-- Cart Icon -->
                    <Link
                        href="#"
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
                            class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-secondary text-[10px] font-bold text-white shadow-sm ring-2 ring-white"
                            >2</span
                        >
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
                                <div class="px-6 py-4 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">
                                        Signed in as
                                    </p>
                                    <p
                                        class="truncate text-sm font-bold text-gray-900"
                                    >
                                        {{ $page.props.auth.user.name }}
                                    </p>
                                </div>

                                <div class="py-1">
                                    <DropdownLink :href="route('profile.edit')">
                                        Profile Settings
                                    </DropdownLink>
                                    <!-- Add more user links here if needed -->
                                </div>

                                <div class="border-t border-gray-100 py-1">
                                    <DropdownLink
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="text-red-600 hover:bg-red-50 hover:text-red-700 w-full text-left"
                                    >
                                        Log Out
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
                                    <Link
                                        :href="route('login')"
                                        class="flex w-full justify-center rounded-xl bg-primary px-4 py-3 text-sm font-bold text-white shadow-md hover:bg-primary/90 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all mb-6 transform hover:-translate-y-0.5"
                                    >
                                        Log In
                                    </Link>
                                    <div
                                        class="text-xs text-gray-500 font-medium pt-4 border-t border-gray-100"
                                    >
                                        New customer?
                                        <Link
                                            :href="route('register')"
                                            class="font-bold text-primary hover:text-primary/80 transition-colors ml-1"
                                        >
                                            Sign Up
                                        </Link>
                                    </div>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button
                        @click="
                            showingNavigationDropdown =
                                !showingNavigationDropdown
                        "
                        class="inline-flex items-center justify-center rounded-md p-2 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none"
                        :class="textClasses"
                    >
                        <svg
                            class="h-6 w-6"
                            stroke="currentColor"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                :class="{
                                    hidden: showingNavigationDropdown,
                                    'inline-flex': !showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                    hidden: !showingNavigationDropdown,
                                    'inline-flex': showingNavigationDropdown,
                                }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
            :class="{
                block: showingNavigationDropdown,
                hidden: !showingNavigationDropdown,
            }"
            class="sm:hidden"
        >
            <div class="space-y-1 pb-3 pt-2">
                <ResponsiveNavLink href="/" :active="$page.url === '/'">
                    Home
                </ResponsiveNavLink>
                <ResponsiveNavLink href="#" :active="false">
                    About Us
                </ResponsiveNavLink>
                <ResponsiveNavLink href="/category" :active="false">
                    Categories
                </ResponsiveNavLink>
                <ResponsiveNavLink href="#" :active="false">
                    Wishlist
                </ResponsiveNavLink>
                <ResponsiveNavLink href="#" :active="false">
                    Cart
                </ResponsiveNavLink>
            </div>

            <!-- Responsive Settings Options -->
            <div
                class="border-t border-gray-200 pb-1 pt-4"
                v-if="$page.props.auth.user"
            >
                <div class="px-4">
                    <div class="text-base font-medium text-gray-800">
                        {{ $page.props.auth.user.name }}
                    </div>
                    <div class="text-sm font-medium text-gray-500">
                        {{ $page.props.auth.user.email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink :href="route('profile.edit')">
                        Profile
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        Log Out
                    </ResponsiveNavLink>
                </div>
            </div>
            <div class="border-t border-gray-200 pb-1 pt-4" v-else>
                <div class="mt-3 space-y-1">
                    <ResponsiveNavLink :href="route('login')">
                        Log in
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('register')">
                        Register
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </nav>
</template>
