<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const form = useForm({
    name: "",
    email: "",
    phone: "",
    message: "",
});

const submit = () => {
    form.clearErrors();

    let hasErrors = false;

    if (!form.name.trim()) {
        form.setError("name", "Name is required.");
        hasErrors = true;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!form.email.trim()) {
        form.setError("email", "Email is required.");
        hasErrors = true;
    } else if (!emailRegex.test(form.email)) {
        form.setError("email", "Please enter a valid email address.");
        hasErrors = true;
    }

    if (!form.message.trim()) {
        form.setError("message", "Message is required.");
        hasErrors = true;
    }

    if (hasErrors) return;

    form.post(route("contact.submit"), {
        onSuccess: () => form.reset(),
    });
};

const faqs = ref([
    {
        question: "How long does it take to process an order?",
        answer: "Most orders are processed within 24-48 hours. Shipping times vary depending on your location and chosen shipping method.",
        open: false,
    },
    {
        question: "Do you offer international shipping?",
        answer: "Yes, we ship our beautiful cards and gifts worldwide. Shipping costs and delivery times will be calculated at checkout.",
        open: false,
    },
    {
        question: "Can I customize my greeting cards?",
        answer: "Absolutely! Many of our cards have customization options. Look for the 'Personalize' button on the product page.",
        open: false,
    },
    {
        question: "What is your return policy?",
        answer: "We want you to be 100% satisfied. If there's an issue with your order, please contact us within 14 days for a replacement or refund.",
        open: false,
    },
]);

const toggleFaq = (index) => {
    faqs.value[index].open = !faqs.value[index].open;
};
</script>

<template>
    <Head title="Contact Us">
        <link
            v-if="$page.props.settings?.logo"
            rel="icon"
            :href="$page.props.settings.logo"
        />
        <meta
            name="description"
            content="Reach out to Benny's Cards for inquiries and support. Compact and efficient support channel."
        />
    </Head>

    <AuthenticatedLayout :transparent-header="false">
        <!-- Compact Hero Section -->
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
                    Support Center
                </h1>
                <h2 class="text-3xl md:text-4xl font-black mb-4">
                    Contact
                    <span class="text-primary italic">Benny's Cards</span>
                </h2>
                <p
                    class="text-gray-400 text-base md:text-lg max-w-xl mx-auto leading-relaxed opacity-80"
                >
                    We're here to help you create something special. Reach out
                    via form or direct channels.
                </p>
            </div>
        </div>

        <div
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20 pb-16"
        >
            <div
                class="bg-white rounded-[2rem] shadow-2xl shadow-gray-200/50 border border-gray-100 overflow-hidden"
            >
                <div class="grid grid-cols-1 lg:grid-cols-12">
                    <!-- Left Side: Compact Contact Info -->
                    <div
                        class="lg:col-span-5 bg-gray-50/50 p-8 md:p-12 border-b lg:border-b-0 lg:border-r border-gray-100"
                    >
                        <div class="space-y-8">
                            <div>
                                <h3
                                    class="text-2xl font-extrabold text-gray-900 mb-2"
                                >
                                    Get in Touch
                                </h3>
                                <p class="text-gray-500 text-base">
                                    Find us or reach out directly.
                                </p>
                            </div>

                            <div class="space-y-6">
                                <!-- Visit Us -->
                                <div class="flex gap-4">
                                    <div
                                        class="shrink-0 w-10 h-10 bg-white shadow-sm border border-gray-100 rounded-xl flex items-center justify-center text-primary"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
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
                                    <div class="space-y-0.5">
                                        <h4
                                            class="text-xs font-bold uppercase tracking-widest text-gray-400"
                                        >
                                            Headquarters
                                        </h4>
                                        <p
                                            class="text-gray-900 font-bold text-base leading-tight"
                                        >
                                            {{
                                                $page.props.settings?.address ||
                                                "103 Subash Street, Nagercoil, Nagercoil 629001"
                                            }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Email Us -->
                                <div class="flex gap-4">
                                    <div
                                        class="shrink-0 w-10 h-10 bg-white shadow-sm border border-gray-100 rounded-xl flex items-center justify-center text-blue-500"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                            />
                                        </svg>
                                    </div>
                                    <div class="space-y-0.5">
                                        <h4
                                            class="text-xs font-bold uppercase tracking-widest text-gray-400"
                                        >
                                            Email Address
                                        </h4>
                                        <a
                                            :href="
                                                'mailto:' +
                                                ($page.props.settings?.email ||
                                                    'bennycards@gmail.com')
                                            "
                                            class="block text-gray-900 font-bold text-base hover:text-primary transition-colors"
                                        >
                                            {{
                                                $page.props.settings?.email ||
                                                "bennycards@gmail.com"
                                            }}
                                        </a>
                                    </div>
                                </div>

                                <!-- Call Us -->
                                <div class="flex gap-4">
                                    <div
                                        class="shrink-0 w-10 h-10 bg-white shadow-sm border border-gray-100 rounded-xl flex items-center justify-center text-green-500"
                                    >
                                        <svg
                                            class="w-5 h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                            />
                                        </svg>
                                    </div>
                                    <div class="space-y-0.5">
                                        <h4
                                            class="text-xs font-bold uppercase tracking-widest text-gray-400"
                                        >
                                            Support Line
                                        </h4>
                                        <a
                                            :href="
                                                'tel:' +
                                                ($page.props.settings?.phone ||
                                                    '+91 8220561954')
                                            "
                                            class="block text-gray-900 font-bold text-base hover:text-primary transition-colors"
                                        >
                                            {{
                                                $page.props.settings?.phone ||
                                                "+91 8220561954"
                                            }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-8 border-t border-gray-200/60">
                                <p
                                    class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4"
                                >
                                    Our Presence
                                </p>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        v-for="city in [
                                            'Nagercoil',
                                            'Marthandam',
                                            'Thirunelveli',
                                            'Chennai',
                                        ]"
                                        :key="city"
                                        class="px-3 py-1 bg-white border border-gray-100 shadow-sm rounded-full text-sm font-bold text-gray-600 hover:text-primary transition-colors cursor-default"
                                    >
                                        {{ city }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Sleek Contact Form -->
                    <div class="lg:col-span-7 p-8 md:p-12">
                        <div
                            v-if="$page.props.flash?.success"
                            class="mb-6 bg-green-50 border border-green-100 text-green-700 px-4 py-3 rounded-2xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-500"
                        >
                            <svg
                                class="h-5 w-5 text-green-500"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                            <span class="text-sm font-bold">{{
                                $page.props.flash.success
                            }}</span>
                        </div>

                        <form @submit.prevent="submit" class="space-y-5">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label
                                        for="name"
                                        class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1"
                                        >Full Name</label
                                    >
                                    <input
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        placeholder="John Doe"
                                        class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-base focus:bg-white focus:ring-0 focus:border-primary transition-all duration-200"
                                        :class="{
                                            'border-red-400': form.errors.name,
                                        }"
                                    />
                                    <p
                                        v-if="form.errors.name"
                                        class="mt-1 text-[10px] text-red-500 ml-1 font-bold"
                                    >
                                        {{ form.errors.name }}
                                    </p>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        for="email"
                                        class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1"
                                        >Email Address</label
                                    >
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        placeholder="john@example.com"
                                        class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-base focus:bg-white focus:ring-0 focus:border-primary transition-all duration-200"
                                        :class="{
                                            'border-red-400': form.errors.email,
                                        }"
                                    />
                                    <p
                                        v-if="form.errors.email"
                                        class="mt-1 text-[10px] text-red-500 ml-1 font-bold"
                                    >
                                        {{ form.errors.email }}
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    for="phone"
                                    class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1"
                                    >Phone Number</label
                                >
                                <input
                                    id="phone"
                                    v-model="form.phone"
                                    type="tel"
                                    placeholder="+91 00000 00000"
                                    class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-base focus:bg-white focus:ring-0 focus:border-primary transition-all duration-200"
                                />
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    for="message"
                                    class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1"
                                    >Your Message</label
                                >
                                <textarea
                                    id="message"
                                    v-model="form.message"
                                    rows="4"
                                    placeholder="How can we help?"
                                    class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 text-base focus:bg-white focus:ring-0 focus:border-primary transition-all duration-200 resize-none"
                                    :class="{
                                        'border-red-400': form.errors.message,
                                    }"
                                ></textarea>
                                <p
                                    v-if="form.errors.message"
                                    class="mt-1 text-[10px] text-red-500 ml-1 font-bold"
                                >
                                    {{ form.errors.message }}
                                </p>
                            </div>
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="w-full bg-gray-900 text-white font-black text-sm uppercase tracking-widest py-5 rounded-xl hover:bg-primary transition-all duration-300 shadow-lg active:scale-[0.98] disabled:opacity-50"
                            >
                                <span v-if="form.processing">Sending...</span>
                                <span v-else>Send Message</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sleek FAQ Section -->
            <div class="mt-20 max-w-3xl mx-auto">
                <div class="text-center mb-10">
                    <h2
                        class="text-xs font-bold uppercase tracking-[0.3em] text-primary mb-2"
                    >
                        FAQ
                    </h2>
                    <h3 class="text-3xl font-black text-gray-900">
                        Common Questions
                    </h3>
                </div>

                <div class="grid grid-cols-1 gap-3">
                    <div
                        v-for="(faq, index) in faqs"
                        :key="index"
                        class="bg-white rounded-2xl border border-gray-100 transition-all duration-300 overflow-hidden"
                        :class="{ 'shadow-lg border-primary/20': faq.open }"
                    >
                        <button
                            @click="toggleFaq(index)"
                            class="w-full px-6 py-5 text-left flex items-center justify-between group"
                        >
                            <span
                                class="text-base font-bold text-gray-900 group-hover:text-primary transition-colors"
                                >{{ faq.question }}</span
                            >
                            <svg
                                class="w-4 h-4 text-gray-400 transition-transform duration-300"
                                :class="{ 'rotate-180 text-primary': faq.open }"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>
                        <div
                            v-show="faq.open"
                            class="px-6 pb-6 animate-in fade-in slide-in-from-top-1"
                        >
                            <p class="text-gray-500 text-sm leading-relaxed">
                                {{ faq.answer }}
                            </p>
                        </div>
                    </div>
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
