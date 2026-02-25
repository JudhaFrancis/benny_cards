<script setup>
import { ref, watch } from "vue";
import { useForm, Link, router } from "@inertiajs/vue3";
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import {
    XMarkIcon,
    UserCircleIcon,
    LockClosedIcon,
    KeyIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps({
    isOpen: {
        type: Boolean,
        required: true,
    },
    canResetPassword: {
        type: Boolean,
        default: true,
    },
    initialRegister: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["close"]);

const isRegister = ref(props.initialRegister);

watch(
    () => props.isOpen,
    (isOpen) => {
        if (isOpen) {
            isRegister.value = props.initialRegister;
        }
    },
);

const loginForm = useForm({
    email: "",
    password: "",
    remember: false,
});

const registerForm = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submitLogin = () => {
    loginForm.post(route("login"), {
        onFinish: () => loginForm.reset("password"),
        onSuccess: () => emit("close"),
    });
};

const submitRegister = () => {
    registerForm.post(route("register"), {
        onFinish: () => registerForm.reset("password", "password_confirmation"),
        onSuccess: () => emit("close"),
    });
};

const toggleMode = () => {
    isRegister.value = !isRegister.value;
    loginForm.clearErrors();
    registerForm.clearErrors();
};

const handleClose = () => {
    emit("close");
    // Remove query params login/register if they exist
    const url = new URL(window.location.href);
    if (url.searchParams.has("login") || url.searchParams.has("register")) {
        url.searchParams.delete("login");
        url.searchParams.delete("register");
        window.history.replaceState({}, "", url.pathname + url.search);
    }
};
</script>

<template>
    <TransitionRoot as="template" :show="isOpen">
        <Dialog as="div" class="relative z-[200]" @close="handleClose">
            <!-- Backdrop -->
            <TransitionChild
                as="template"
                enter="transition-opacity ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm" />
            </TransitionChild>

            <!-- Modal Panel -->
            <div
                class="fixed inset-0 z-10 flex items-center justify-center p-4"
            >
                <TransitionChild
                    as="template"
                    enter="transition ease-out duration-300"
                    enter-from="opacity-0 scale-95 translate-y-4"
                    enter-to="opacity-100 scale-100 translate-y-0"
                    leave="transition ease-in duration-200"
                    leave-from="opacity-100 scale-100 translate-y-0"
                    leave-to="opacity-0 scale-95 translate-y-4"
                >
                    <DialogPanel
                        class="relative w-full bg-white/90 backdrop-blur-2xl rounded-[2rem] shadow-2xl border border-white/40 overflow-hidden transition-all duration-300"
                        :class="isRegister ? 'max-w-lg' : 'max-w-md'"
                    >
                        <!-- Header -->
                        <div class="px-8 pt-8 pb-6 border-b border-gray-100/60">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2
                                        class="text-2xl font-black text-gray-900 tracking-tight transition-all duration-300"
                                    >
                                        {{
                                            isRegister
                                                ? "Create an Account"
                                                : "Welcome Back"
                                        }}
                                    </h2>
                                    <p
                                        class="text-sm text-gray-500 mt-1 transition-all duration-300"
                                    >
                                        {{
                                            isRegister
                                                ? "Join Benny Cards today"
                                                : "Sign in to your Benny Cards account"
                                        }}
                                    </p>
                                </div>
                                <button
                                    @click="handleClose"
                                    class="p-2 bg-gray-100 rounded-xl text-gray-400 hover:text-gray-600 transition-colors"
                                >
                                    <XMarkIcon class="h-5 w-5" />
                                </button>
                            </div>
                        </div>

                        <!-- Form Body -->
                        <div class="px-8 py-6">
                            <!-- Global Errors -->
                            <div
                                v-if="
                                    isRegister
                                        ? registerForm.errors.email ||
                                          registerForm.errors.password ||
                                          registerForm.errors.name
                                        : loginForm.errors.email ||
                                          loginForm.errors.password
                                "
                                class="mb-4 p-3 bg-red-50 border border-red-100 rounded-xl text-sm text-red-600"
                            >
                                <span v-if="isRegister">
                                    {{
                                        registerForm.errors.name ||
                                        registerForm.errors.email ||
                                        registerForm.errors.password
                                    }}
                                </span>
                                <span v-else>
                                    {{
                                        loginForm.errors.email ||
                                        loginForm.errors.password
                                    }}
                                </span>
                            </div>

                            <!-- Login Form -->
                            <form
                                v-if="!isRegister"
                                @submit.prevent="submitLogin"
                                class="space-y-5"
                            >
                                <!-- Email -->
                                <div class="space-y-1.5">
                                    <label
                                        for="login-email"
                                        class="text-xs font-black text-gray-700 uppercase tracking-widest"
                                        >Email Address</label
                                    >
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                                        >
                                            <UserCircleIcon
                                                class="h-5 w-5 text-gray-400"
                                            />
                                        </div>
                                        <input
                                            id="login-email"
                                            v-model="loginForm.email"
                                            type="email"
                                            required
                                            autofocus
                                            autocomplete="username"
                                            placeholder="you@example.com"
                                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                                        />
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="space-y-1.5">
                                    <label
                                        for="login-password"
                                        class="text-xs font-black text-gray-700 uppercase tracking-widest"
                                        >Password</label
                                    >
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                                        >
                                            <LockClosedIcon
                                                class="h-5 w-5 text-gray-400"
                                            />
                                        </div>
                                        <input
                                            id="login-password"
                                            v-model="loginForm.password"
                                            type="password"
                                            required
                                            autocomplete="current-password"
                                            placeholder="••••••••"
                                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                                        />
                                    </div>
                                </div>

                                <!-- Remember & Forgot -->
                                <div class="flex items-center justify-between">
                                    <label
                                        class="flex items-center gap-2 cursor-pointer"
                                    >
                                        <input
                                            type="checkbox"
                                            v-model="loginForm.remember"
                                            class="w-4 h-4 rounded text-primary border-gray-300 focus:ring-primary"
                                        />
                                        <span
                                            class="text-xs font-bold text-gray-600"
                                            >Remember me</span
                                        >
                                    </label>
                                    <Link
                                        v-if="canResetPassword"
                                        :href="route('password.request')"
                                        class="text-xs font-bold text-primary hover:underline"
                                        @click="handleClose"
                                    >
                                        Forgot password?
                                    </Link>
                                </div>

                                <!-- Submit -->
                                <button
                                    type="submit"
                                    :disabled="loginForm.processing"
                                    class="w-full py-3.5 bg-primary text-white font-black text-sm uppercase tracking-widest rounded-2xl hover:bg-primary/90 active:scale-98 transition-all shadow-lg shadow-primary/20 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <span v-if="loginForm.processing"
                                        >Signing In...</span
                                    >
                                    <span v-else>Log In</span>
                                </button>
                            </form>

                            <!-- Register Form -->
                            <form
                                v-else
                                @submit.prevent="submitRegister"
                                class="space-y-5"
                            >
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-5"
                                >
                                    <!-- Name -->
                                    <div class="space-y-1.5">
                                        <label
                                            for="register-name"
                                            class="text-xs font-black text-gray-700 uppercase tracking-widest"
                                            >Full Name</label
                                        >
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                                            >
                                                <UserCircleIcon
                                                    class="h-5 w-5 text-gray-400"
                                                />
                                            </div>
                                            <input
                                                id="register-name"
                                                v-model="registerForm.name"
                                                type="text"
                                                required
                                                autofocus
                                                autocomplete="name"
                                                placeholder="John Doe"
                                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                                            />
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="space-y-1.5">
                                        <label
                                            for="register-email"
                                            class="text-xs font-black text-gray-700 uppercase tracking-widest"
                                            >Email Address</label
                                        >
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                                            >
                                                <UserCircleIcon
                                                    class="h-5 w-5 text-gray-400"
                                                />
                                            </div>
                                            <input
                                                id="register-email"
                                                v-model="registerForm.email"
                                                type="email"
                                                required
                                                autocomplete="username"
                                                placeholder="you@example.com"
                                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-5"
                                >
                                    <!-- Password -->
                                    <div class="space-y-1.5">
                                        <label
                                            for="register-password"
                                            class="text-xs font-black text-gray-700 uppercase tracking-widest"
                                            >Password</label
                                        >
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                                            >
                                                <LockClosedIcon
                                                    class="h-5 w-5 text-gray-400"
                                                />
                                            </div>
                                            <input
                                                id="register-password"
                                                v-model="registerForm.password"
                                                type="password"
                                                required
                                                autocomplete="new-password"
                                                placeholder="••••••••"
                                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                                            />
                                        </div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="space-y-1.5">
                                        <label
                                            for="register-password-confirm"
                                            class="text-xs font-black text-gray-700 uppercase tracking-widest"
                                            >Confirm Password</label
                                        >
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                                            >
                                                <KeyIcon
                                                    class="h-5 w-5 text-gray-400"
                                                />
                                            </div>
                                            <input
                                                id="register-password-confirm"
                                                v-model="
                                                    registerForm.password_confirmation
                                                "
                                                type="password"
                                                required
                                                autocomplete="new-password"
                                                placeholder="••••••••"
                                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <button
                                    type="submit"
                                    :disabled="registerForm.processing"
                                    class="w-full py-3.5 bg-primary text-white font-black text-sm uppercase tracking-widest rounded-2xl hover:bg-primary/90 active:scale-98 transition-all shadow-lg shadow-primary/20 disabled:opacity-50 disabled:cursor-not-allowed"
                                >
                                    <span v-if="registerForm.processing"
                                        >Creating Account...</span
                                    >
                                    <span v-else>Sign Up</span>
                                </button>
                            </form>
                        </div>

                        <!-- Footer -->
                        <div
                            class="px-8 pb-8 text-center bg-gray-50/50 pt-6 mt-2"
                        >
                            <p class="text-sm text-gray-500">
                                {{
                                    isRegister
                                        ? "Already have an account?"
                                        : "New customer?"
                                }}
                                <button
                                    type="button"
                                    @click="toggleMode"
                                    class="font-black text-primary hover:underline ml-1 focus:outline-none"
                                >
                                    {{ isRegister ? "Log In" : "Sign Up" }}
                                </button>
                            </p>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
