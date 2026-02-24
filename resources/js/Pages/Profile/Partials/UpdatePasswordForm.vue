<script setup>
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import { LockClosedIcon, KeyIcon } from "@heroicons/vue/24/outline";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const updatePassword = () => {
    form.put(route("password.update"), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset("password", "password_confirmation");
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset("current_password");
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-xl font-black text-gray-900 tracking-tight">
                Update Password
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Ensure your account is using a long, random password to stay
                secure.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-5">
            <!-- Current Password -->
            <div class="space-y-1.5">
                <label
                    for="current_password"
                    class="text-xs font-black text-gray-700 uppercase tracking-widest"
                    >Current Password</label
                >
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                    >
                        <LockClosedIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <input
                        id="current_password"
                        ref="currentPasswordInput"
                        v-model="form.current_password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                    />
                </div>
                <InputError
                    :message="form.errors.current_password"
                    class="mt-2"
                />
            </div>

            <!-- New Password -->
            <div class="space-y-1.5">
                <label
                    for="password"
                    class="text-xs font-black text-gray-700 uppercase tracking-widest"
                    >New Password</label
                >
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                    >
                        <LockClosedIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <input
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                    />
                </div>
                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="space-y-1.5">
                <label
                    for="password_confirmation"
                    class="text-xs font-black text-gray-700 uppercase tracking-widest"
                    >Confirm Password</label
                >
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                    >
                        <KeyIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        required
                        autocomplete="new-password"
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                    />
                </div>
                <InputError
                    :message="form.errors.password_confirmation"
                    class="mt-2"
                />
            </div>

            <div class="flex items-center gap-4 pt-2">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="px-6 py-3 bg-primary text-white font-black text-xs uppercase tracking-widest rounded-xl hover:bg-primary/90 active:scale-95 transition-all shadow-md shadow-primary/20 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Save
                </button>

                <Transition
                    enter-active-class="transition ease-in-out duration-300"
                    enter-from-class="opacity-0 translate-y-1"
                    leave-active-class="transition ease-in-out duration-300"
                    leave-to-class="opacity-0 translate-y-1"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm font-bold text-green-600 flex items-center gap-1.5"
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
                                d="M5 13l4 4L19 7"
                            ></path>
                        </svg>
                        Saved successfully.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
