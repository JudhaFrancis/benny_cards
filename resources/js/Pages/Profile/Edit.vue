<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <!-- Compact Hero Section (Synced with Product Design) -->
        <div class="relative bg-gray-900 py-12 md:py-16 overflow-hidden">
            <!-- Decorative Background Elements -->
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
                <nav
                    class="flex justify-center mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gray-500"
                    aria-label="Breadcrumb"
                >
                    <ol class="flex items-center space-x-2">
                        <li>
                            <Link
                                :href="route('home')"
                                class="hover:text-primary transition-colors"
                                >Home</Link
                            >
                        </li>
                        <li>
                            <div class="flex items-center space-x-2">
                                <svg
                                    class="w-2.5 h-2.5 text-gray-700"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="3"
                                        d="M9 5l7 7-7 7"
                                    />
                                </svg>
                                <span class="text-gray-400">Account Info</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <h1 class="text-2xl md:text-3xl font-black text-white px-4">
                    Account Information
                </h1>
            </div>
        </div>

        <div class="py-12">
            <div class="mx-auto max-w-4xl space-y-8 sm:px-6 lg:px-8">
                <!-- Profile Information Card -->
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-10"
                >
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <!-- Update Password Card -->
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-10"
                >
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <!-- Delete Account Card (Future) -->
                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-10"
                >
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
