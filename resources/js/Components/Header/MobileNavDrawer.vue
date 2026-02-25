<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import {
    XMarkIcon,
    HomeIcon,
    InformationCircleIcon,
    UserIcon,
    HeartIcon,
    ShoppingBagIcon,
    ChevronRightIcon,
    ArrowRightOnRectangleIcon,
    UserCircleIcon,
} from "@heroicons/vue/24/outline";
import LoginModal from "@/Components/Auth/LoginModal.vue";

defineProps({
    isOpen: Boolean,
    categories: Array,
});

const emit = defineEmits(["close"]);

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

const mainLinks = [
    { name: "Home", href: "/", icon: HomeIcon },
    { name: "About Us", href: "/about", icon: InformationCircleIcon },
    { name: "Wishlist", href: route("wishlist.index"), icon: HeartIcon },
    { name: "Cart", href: "#", icon: ShoppingBagIcon },
];
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
                                    Menu
                                </h2>
                                <span
                                    class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mt-3"
                                >
                                    Navigation
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

                        <div class="flex-1 px-6 py-8 space-y-10">
                            <!-- Account Section -->
                            <div
                                v-if="$page.props.auth.user"
                                class="bg-gray-900 rounded-[2rem] p-6 shadow-xl shadow-gray-200"
                            >
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center border border-white/10"
                                    >
                                        <UserIcon
                                            class="w-6 h-6 text-primary"
                                        />
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span
                                            class="text-sm font-black text-white truncate"
                                            >{{
                                                $page.props.auth.user.name
                                            }}</span
                                        >
                                        <span
                                            class="text-[10px] font-bold text-gray-400 truncate"
                                            >{{
                                                $page.props.auth.user.email
                                            }}</span
                                        >
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 mt-6">
                                    <Link
                                        :href="route('profile.edit')"
                                        class="flex items-center justify-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 rounded-xl transition-colors text-[10px] font-black text-white uppercase tracking-widest"
                                    >
                                        Profile
                                    </Link>
                                    <Link
                                        :href="route('logout')"
                                        method="post"
                                        as="button"
                                        class="flex items-center justify-center gap-2 px-4 py-2.5 bg-red-500/10 hover:bg-red-500/20 rounded-xl transition-colors text-[10px] font-black text-red-400 uppercase tracking-widest"
                                    >
                                        Logout
                                    </Link>
                                </div>
                            </div>

                            <!-- Guest Section -->
                            <div
                                v-else
                                class="rounded-[2rem] bg-gray-50 border border-gray-100 p-6 space-y-4"
                            >
                                <div class="space-y-1">
                                    <h3
                                        class="text-base font-black text-gray-900 tracking-tight"
                                    >
                                        Welcome to Benny Cards
                                    </h3>
                                    <p
                                        class="text-xs text-gray-500 leading-relaxed"
                                    >
                                        Sign in to access your account, track
                                        orders & more.
                                    </p>
                                </div>

                                <button
                                    @click="openLoginModal"
                                    class="w-full flex items-center justify-center gap-2 py-3 bg-primary text-white font-black text-[11px] uppercase tracking-widest rounded-2xl shadow-lg shadow-primary/20 active:scale-95 transition-all hover:bg-primary/90"
                                >
                                    <UserCircleIcon class="w-4 h-4" />
                                    Log In
                                </button>

                                <p class="text-center text-xs text-gray-500">
                                    New customer?
                                    <button
                                        @click="openRegisterModal"
                                        class="font-black text-primary hover:underline ml-0.5"
                                    >
                                        Sign Up
                                    </button>
                                </p>
                            </div>

                            <!-- Main Links -->
                            <div>
                                <h3
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 px-2"
                                >
                                    Main Menu
                                </h3>
                                <div class="space-y-2">
                                    <Link
                                        v-for="link in mainLinks"
                                        :key="link.name"
                                        :href="link.href"
                                        class="flex items-center justify-between p-4 rounded-2xl transition-all duration-300 active:scale-[0.98] group"
                                        :class="
                                            $page.url === link.href
                                                ? 'bg-primary/5 text-primary'
                                                : 'bg-white/50 text-gray-600 hover:bg-gray-50'
                                        "
                                    >
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="p-2 rounded-xl transition-colors"
                                                :class="
                                                    $page.url === link.href
                                                        ? 'bg-primary text-white'
                                                        : 'bg-gray-100 text-gray-400 group-hover:bg-white group-hover:text-primary'
                                                "
                                            >
                                                <component
                                                    :is="link.icon"
                                                    class="w-5 h-5"
                                                />
                                            </div>
                                            <span class="text-sm font-bold">{{
                                                link.name
                                            }}</span>
                                        </div>
                                        <ChevronRightIcon
                                            class="w-4 h-4 transition-transform group-hover:translate-x-1"
                                            :class="
                                                $page.url === link.href
                                                    ? 'text-primary'
                                                    : 'text-gray-300'
                                            "
                                        />
                                    </Link>
                                </div>
                            </div>

                            <!-- Categories Grid -->
                            <div v-if="categories && categories.length > 0">
                                <h3
                                    class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-6 px-2"
                                >
                                    Collections
                                </h3>
                                <div class="grid grid-cols-2 gap-3">
                                    <Link
                                        v-for="category in categories"
                                        :key="category.id"
                                        :href="
                                            route(
                                                'category.index',
                                                category.slug,
                                            )
                                        "
                                        class="group flex flex-col items-center gap-3 p-4 rounded-[2rem] border border-gray-100 bg-white/50 transition-all duration-300 active:scale-95 hover:border-primary/30 hover:shadow-lg hover:shadow-primary/5"
                                    >
                                        <div
                                            class="w-12 h-12 rounded-2xl overflow-hidden bg-gray-100 group-hover:ring-4 group-hover:ring-primary/10 transition-all"
                                        >
                                            <img
                                                v-if="category.photo"
                                                :src="category.photo"
                                                :alt="category.title"
                                                class="w-full h-full object-cover"
                                            />
                                            <div
                                                v-else
                                                class="w-full h-full flex items-center justify-center bg-primary/5 text-primary"
                                            >
                                                <ShoppingBagIcon
                                                    class="w-6 h-6"
                                                />
                                            </div>
                                        </div>
                                        <span
                                            class="text-[10px] font-black text-gray-600 uppercase tracking-wider text-center group-hover:text-primary transition-colors"
                                        >
                                            {{ category.title }}
                                        </span>
                                    </Link>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div
                            class="sticky bottom-0 mt-auto p-6 bg-white/80 backdrop-blur-xl border-t border-gray-100/50 flex items-center justify-center"
                        >
                            <span
                                class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]"
                            >
                                Benny Cards &copy; 2024
                            </span>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>

    <!-- Login Modal -->
    <LoginModal
        :is-open="isLoginModalOpen"
        :initial-register="initialRegister"
        @close="isLoginModalOpen = false"
    />
</template>
