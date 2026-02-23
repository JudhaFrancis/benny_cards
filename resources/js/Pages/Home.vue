<script setup>
import { Head } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BannerSection from "@/Components/Home/BannerSection.vue";
import CategorySection from "@/Components/Home/CategorySection.vue";
import InvitationCardsSection from "@/Components/Home/InvitationCardsSection.vue";
import GiftsSection from "@/Components/Home/GiftsSection.vue";
import PriceRangeSection from "@/Components/Home/PriceRangeSection.vue";
import FeaturedProductsSection from "@/Components/Home/FeaturedProductsSection.vue";
import ProductsSection from "@/Components/Home/ProductsSection.vue";

defineProps({
    banners: {
        type: Array,
        default: () => [],
    },
    products: {
        type: Array,
        default: () => [],
    },
    categories: {
        type: Array,
        default: () => [],
    },
    invitationCards: {
        type: Array,
        default: () => [],
    },
    gifts: {
        type: Array,
        default: () => [],
    },
    priceRanges: {
        type: Array,
        default: () => [],
    },
    featuredProducts: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Head title="Home">
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
        <BannerSection :banners="banners" />
        <CategorySection :categories="categories" />
        <InvitationCardsSection :invitationCards="invitationCards" />
        <GiftsSection :gifts="gifts" />
        <PriceRangeSection :priceRanges="priceRanges" />
        <FeaturedProductsSection :featuredProducts="featuredProducts" />
        <ProductsSection :products="products" />
    </AuthenticatedLayout>
</template>
