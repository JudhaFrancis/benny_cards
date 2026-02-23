<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
    inactiveClass: {
        type: String,
        default: "text-gray-500 hover:text-gray-900 hover:bg-gray-50",
    },
});

const classes = computed(() =>
    props.active
        ? "inline-flex items-center px-3 py-2 text-sm font-semibold text-primary bg-primary/10 rounded-full transition-all duration-200 ease-in-out"
        : `inline-flex items-center px-3 py-2 text-sm font-medium rounded-full transition-all duration-200 ease-in-out ${props.inactiveClass}`,
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
