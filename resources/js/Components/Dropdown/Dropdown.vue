<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";

const props = defineProps({
    align: {
        type: String,
        default: "right",
    },
    width: {
        type: String,
        default: "48",
    },
    contentClasses: {
        type: String,
        default: "py-1 bg-white",
    },
    mode: {
        type: String,
        default: "click", // 'click' or 'hover'
    },
});

const closeOnEscape = (e) => {
    if (open.value && e.key === "Escape") {
        open.value = false;
    }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));
onUnmounted(() => document.removeEventListener("keydown", closeOnEscape));

const widthClass = computed(() => {
    return {
        48: "w-48",
        56: "w-56",
        64: "w-64",
        72: "w-72",
        80: "w-80",
        96: "w-96",
        "3xl": "w-screen max-w-3xl",
        "4xl": "w-screen max-w-4xl",
        "5xl": "w-screen max-w-5xl",
    }[props.width.toString()];
});

const alignmentClasses = computed(() => {
    if (props.align === "left") {
        return "ltr:origin-top-left rtl:origin-top-right start-0";
    } else if (props.align === "right") {
        return "ltr:origin-top-right rtl:origin-top-left end-0";
    } else if (props.align === "center") {
        return "origin-top left-1/2 -translate-x-1/2";
    } else if (props.align === "header-center") {
        return "origin-top fixed left-1/2 -translate-x-1/2";
    } else {
        return "origin-top";
    }
});

const positionClass = computed(() => {
    return props.align === "header-center" ? "fixed" : "absolute";
});

const open = ref(false);
let timeout = null;

const openDropdown = () => {
    if (props.mode === "hover") {
        clearTimeout(timeout);
        open.value = true;
    }
};

const closeDropdown = () => {
    if (props.mode === "hover") {
        timeout = setTimeout(() => {
            open.value = false;
        }, 200); // 200ms delay to bridge the gap
    }
};
</script>

<template>
    <div
        class="relative"
        @mouseenter="openDropdown"
        @mouseleave="closeDropdown"
    >
        <div @click="mode === 'click' ? (open = !open) : null">
            <slot name="trigger" />
        </div>

        <!-- Full Screen Dropdown Overlay -->
        <div
            v-show="open && mode !== 'hover'"
            class="fixed inset-0 z-40"
            @click="open = false"
        ></div>

        <Transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-show="open"
                class="z-50 mt-2 rounded-md shadow-lg"
                :class="[
                    widthClass,
                    alignmentClasses,
                    positionClass,
                    align === 'header-center' ? 'top-16' : '',
                ]"
                @click="open = false"
            >
                <div
                    class="rounded-md ring-1 ring-black ring-opacity-5"
                    :class="contentClasses"
                >
                    <slot name="content" />
                </div>
            </div>
        </Transition>
    </div>
</template>
