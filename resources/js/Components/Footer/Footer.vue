<script setup>
import { Link } from "@inertiajs/vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="bg-gray-900 text-gray-300 border-t border-gray-800">
        <!-- Main Footer Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Brand Column -->
                <div class="space-y-6">
                    <div class="flex items-center space-x-2">
                        <Link href="/" class="flex items-center">
                            <img
                                v-if="$page.props.settings?.logo"
                                :src="$page.props.settings.logo"
                                alt="Logo"
                                class="h-20 w-auto"
                            />
                            <ApplicationLogo
                                v-else
                                class="h-20 w-auto fill-current text-white"
                            />
                            <span
                                v-if="!$page.props.settings?.logo"
                                class="ml-2 text-xl font-bold text-white tracking-tight"
                            >
                                Benny's Cards
                            </span>
                        </Link>
                    </div>
                    <p
                        v-if="$page.props.settings?.description"
                        class="text-sm text-gray-400 leading-relaxed max-w-xs"
                    >
                        {{ $page.props.settings.description }}
                    </p>
                    <div class="flex space-x-4">
                        <!-- Social Media Icons -->
                        <a
                            v-if="$page.props.settings?.facebook_url"
                            :href="$page.props.settings.facebook_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-gray-400 hover:text-white transition-colors"
                        >
                            <span class="sr-only">Facebook</span>
                            <svg
                                class="h-6 w-6"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </a>
                        <a
                            v-if="$page.props.settings?.instagram_url"
                            :href="$page.props.settings.instagram_url"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-gray-400 hover:text-white transition-colors"
                        >
                            <span class="sr-only">Instagram</span>
                            <svg
                                class="h-6 w-6"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.37c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-white font-semibold mb-6">Quick Links</h3>
                    <ul class="space-y-4">
                        <li>
                            <Link
                                :href="route('home')"
                                class="text-sm text-gray-400 hover:text-primary transition-colors"
                            >
                                Home
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('about')"
                                class="text-sm text-gray-400 hover:text-primary transition-colors"
                            >
                                About Us
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('category.index')"
                                class="text-sm text-gray-400 hover:text-primary transition-colors"
                            >
                                Shop Categories
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('contact')"
                                class="text-sm text-gray-400 hover:text-primary transition-colors"
                            >
                                Contact Us
                            </Link>
                        </li>
                    </ul>
                </div>

                <!-- Our Branches -->
                <div>
                    <h3 class="text-white font-semibold mb-6">Our Branches</h3>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li>
                            <span
                                class="block hover:text-white transition-colors"
                            >
                                Nagercoil
                            </span>
                        </li>
                        <li>
                            <span
                                class="block hover:text-white transition-colors"
                            >
                                Marthandam
                            </span>
                        </li>
                        <li>
                            <span
                                class="block hover:text-white transition-colors"
                            >
                                Thirunelveli
                            </span>
                        </li>
                        <li>
                            <span
                                class="block hover:text-white transition-colors"
                            >
                                Chennai
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Contact Us -->
                <div>
                    <h3 class="text-white font-semibold mb-6">Contact Us</h3>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li
                            v-if="$page.props.settings?.address"
                            class="flex items-start"
                        >
                            <div class="shrink-0 w-8">
                                <svg
                                    class="h-5 w-5 text-gray-500"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                            </div>
                            <span class="leading-relaxed">{{
                                $page.props.settings.address
                            }}</span>
                        </li>
                        <li
                            v-if="$page.props.settings?.phone"
                            class="flex items-center"
                        >
                            <div class="shrink-0 w-8">
                                <svg
                                    class="h-5 w-5 text-gray-500"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                    />
                                </svg>
                            </div>
                            <span>{{ $page.props.settings.phone }}</span>
                        </li>
                        <li
                            v-if="$page.props.settings?.email"
                            class="flex items-center"
                        >
                            <div class="shrink-0 w-8">
                                <svg
                                    class="h-5 w-5 text-gray-500"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />
                                </svg>
                            </div>
                            <span>{{ $page.props.settings.email }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-800 bg-gray-950">
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row justify-between items-center gap-4"
            >
                <div class="text-xs text-gray-500 text-center md:text-left">
                    &copy; {{ currentYear }} Benny's Cards. All rights reserved.
                </div>

                <!-- Powered By -->
                <div class="text-xs text-gray-500 flex items-center gap-2">
                    <span>Powered by</span>
                    <a
                        href="https://site.agoo.in"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="transition-opacity hover:opacity-80"
                    >
                        <img
                            src="/images/agoo_logo.png"
                            alt="Agoo"
                            class="h-5 w-auto"
                        />
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>
