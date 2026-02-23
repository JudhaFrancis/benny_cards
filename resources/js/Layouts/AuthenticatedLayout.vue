<script setup>
import Header from "@/Components/Header/Header.vue";
import Footer from "@/Components/Footer/Footer.vue";

defineProps({
    transparentHeader: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <div class="flex flex-col min-h-screen">
        <Header :transparent-mode="transparentHeader" />

        <!-- Page Content -->
        <main class="flex-grow">
            <slot />
        </main>

        <Footer />
    </div>
</template>
