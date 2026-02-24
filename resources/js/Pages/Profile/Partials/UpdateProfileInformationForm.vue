<script setup>
import InputError from "@/Components/InputError.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { UserCircleIcon, EnvelopeIcon } from "@heroicons/vue/24/outline";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-xl font-black text-gray-900 tracking-tight">
                Profile Information
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Update your account's profile information and email address.
            </p>
        </header>

        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="mt-6 space-y-5"
        >
            <!-- Name -->
            <div class="space-y-1.5">
                <label
                    for="name"
                    class="text-xs font-black text-gray-700 uppercase tracking-widest"
                    >Name</label
                >
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                    >
                        <UserCircleIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <input
                        id="name"
                        v-model="form.name"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                    />
                </div>
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label
                    for="email"
                    class="text-xs font-black text-gray-700 uppercase tracking-widest"
                    >Email Address</label
                >
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                    >
                        <EnvelopeIcon class="h-5 w-5 text-gray-400" />
                    </div>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        required
                        autocomplete="username"
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-sm font-medium text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all"
                    />
                </div>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-gray-600 underline hover:text-primary focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-bold text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
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
