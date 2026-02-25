<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";

const stats = ref([
    { label: "Premium Designs", value: "5000+" },
    { label: "Happy Customers", value: "10k+" },
    { label: "Years Experience", value: "8+" },
    { label: "Store Branches", value: "4" },
]);

const values = ref([
    {
        title: "Quality First",
        description:
            "We use only the finest materials for our cards and gifts.",
        icon: "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z",
    },
    {
        title: "Fast Delivery",
        description:
            "Our dedicated team ensures your orders reach you on time.",
        icon: "M13 10V3L4 14h7v7l9-11h-7z",
    },
    {
        title: "Customer Focused",
        description:
            "Your satisfaction is our top priority in everything we do.",
        icon: "M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z",
    },
]);
</script>

<template>
    <Head title="About Us">
        <link
            v-if="$page.props.settings?.logo"
            rel="icon"
            :href="$page.props.settings.logo"
        />
        <meta
            v-if="$page.props.settings?.description"
            name="description"
            :content="$page.props.settings.description"
        />
        <meta
            v-if="$page.props.settings?.logo"
            property="og:image"
            :content="$page.props.settings.logo"
        />
    </Head>

    <AuthenticatedLayout :transparent-header="false">
        <!-- Compact Hero Section (Synced with Contact Us) -->
        <div class="relative bg-gray-900 py-12 md:py-20 overflow-hidden">
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
                <h1
                    class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-3"
                >
                    Our Story
                </h1>
                <h2 class="text-3xl md:text-4xl font-black mb-4">
                    Crafting Memories Since
                    <span class="text-primary italic">2018</span>
                </h2>
                <p
                    class="text-gray-400 text-base md:text-lg max-w-xl mx-auto leading-relaxed opacity-80"
                >
                    Benny's Cards started with a simple vision: to make every
                    celebration unforgettable through beautifully designed
                    invitation cards and thoughtful gifts.
                </p>
            </div>
        </div>

        <!-- Main Content -->
        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-12 relative z-20 pb-20"
        >
            <div
                class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden"
            >
                <!-- Stats Section -->
                <div
                    class="grid grid-cols-2 md:grid-cols-4 border-b border-gray-100"
                >
                    <div
                        v-for="stat in stats"
                        :key="stat.label"
                        class="p-8 text-center border-r last:border-r-0 border-gray-100 uppercase"
                    >
                        <p
                            class="text-3xl md:text-4xl font-black text-gray-900 mb-1"
                        >
                            {{ stat.value }}
                        </p>
                        <p
                            class="text-[10px] font-bold tracking-widest text-primary"
                        >
                            {{ stat.label }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-0">
                    <!-- Text Content -->
                    <div class="p-8 md:p-16 space-y-8">
                        <div>
                            <h3 class="text-3xl font-black text-gray-900 mb-4">
                                Who We Are
                            </h3>
                            <p class="text-gray-600 leading-relaxed text-lg">
                                At Benny's Cards, we believe that invitations
                                are more than just paper—they are the first
                                glimpse into your most precious moments. From
                                weddings to grand openings, we provide premium
                                quality cards that reflect your unique style and
                                personality.
                            </p>
                        </div>

                        <div class="space-y-6">
                            <div
                                v-for="value in values"
                                :key="value.title"
                                class="flex gap-4"
                            >
                                <div
                                    class="shrink-0 w-12 h-12 bg-primary/5 rounded-2xl flex items-center justify-center text-primary"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            :d="value.icon"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h4
                                        class="text-gray-900 font-bold text-lg mb-1"
                                    >
                                        {{ value.title }}
                                    </h4>
                                    <p
                                        class="text-gray-500 text-sm leading-relaxed"
                                    >
                                        {{ value.description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image/Visual Content -->
                    <div
                        class="relative bg-gray-50 flex items-center justify-center p-8 md:p-16"
                    >
                        <div class="relative group">
                            <div
                                class="absolute -inset-4 bg-primary/20 rounded-[2rem] blur-2xl group-hover:bg-primary/30 transition-all duration-500"
                            ></div>
                            <div
                                class="relative bg-white p-4 rounded-[2rem] shadow-xl transform group-hover:-translate-y-2 transition-transform duration-500"
                            >
                                <img
                                    :src="$page.props.settings?.logo"
                                    v-if="$page.props.settings?.logo"
                                    alt="Benny's Cards Office"
                                    class="w-full max-w-sm rounded-[1.5rem]"
                                />
                                <div
                                    v-else
                                    class="w-64 h-64 bg-gray-100 rounded-[1.5rem] flex items-center justify-center"
                                >
                                    <span class="text-gray-400 font-bold"
                                        >Benny's Cards</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vision/Mission Section -->
            <div
                class="mt-20 grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto uppercase"
            >
                <div
                    class="bg-primary p-12 rounded-[2rem] text-white shadow-xl shadow-primary/20 transform hover:-translate-y-1 transition-all"
                >
                    <h3
                        class="text-xs font-black tracking-widest mb-4 opacity-80"
                    >
                        Our Vision
                    </h3>
                    <p class="text-xl font-bold leading-relaxed">
                        "To be the global leader in spreading joy through
                        personalized, high-quality celebration essentials."
                    </p>
                </div>
                <div
                    class="bg-gray-900 p-12 rounded-[2rem] text-white shadow-xl shadow-gray-900/20 transform hover:-translate-y-1 transition-all"
                >
                    <h3
                        class="text-xs font-black tracking-widest mb-4 text-primary"
                    >
                        Our Mission
                    </h3>
                    <p class="text-xl font-bold leading-relaxed">
                        "To provide an exceptional experience and creative
                        products that make every milestone special for our
                        customers."
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(20px, -20px) scale(1.1);
    }
    66% {
        transform: translate(-10px, 10px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}
.animate-blob {
    animation: blob 10s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
</style>
