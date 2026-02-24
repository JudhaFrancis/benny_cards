<script setup>
import { ref, computed } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    imageBaseUrl: {
        type: String,
        required: true,
    },
});

const showReviewForm = ref(false);
const starHover = ref(0);
const imagePreviews = ref([]);
const ratingContainer = ref(null);
const fileInput = ref(null);

const reviewForm = useForm({
    rating: 0,
    title: "",
    content: "",
    name: "",
    images: [],
});

const averageRating = computed(() => {
    if (!props.product.reviews || props.product.reviews.length === 0)
        return "0.0";
    const sum = props.product.reviews.reduce((acc, r) => acc + r.rating, 0);
    return (sum / props.product.reviews.length).toFixed(1);
});

const ratingDistribution = computed(() => {
    const counts = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 };
    if (!props.product.reviews) return counts;
    props.product.reviews.forEach((r) => {
        counts[r.rating]++;
    });
    return counts;
});

const getRatingPercentage = (star) => {
    if (!props.product.reviews || props.product.reviews.length === 0) return 0;
    return Math.round(
        (ratingDistribution.value[star] / props.product.reviews.length) * 100,
    );
};

const handleImageUpload = (e) => {
    const files = Array.from(e.target.files);
    const currentImages = [...reviewForm.images];

    files.forEach((file) => {
        currentImages.push(file);
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreviews.value.push(e.target.result);
        };
        reader.readAsDataURL(file);
    });

    reviewForm.images = currentImages;
};

const removeImage = (index) => {
    const currentImages = [...reviewForm.images];
    currentImages.splice(index, 1);
    reviewForm.images = currentImages;
    imagePreviews.value.splice(index, 1);
};

const submitReview = () => {
    if (reviewForm.rating < 1) {
        reviewForm.setError("rating", "The rating field must be at least 1.");
        ratingContainer.value?.scrollIntoView({
            behavior: "smooth",
            block: "center",
        });
        return;
    }

    reviewForm.post(`/product/${props.product.id}/review`, {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            reviewForm.reset();
            imagePreviews.value = [];
            showReviewForm.value = false;
        },
        onError: (errors) => {
            console.error("Review submission errors:", errors);
        },
    });
};
</script>

<template>
    <div class="max-w-4xl">
        <!-- Summary View -->
        <div v-if="!showReviewForm">
            <div class="text-gray-500 mb-10">
                See what others are saying about
                <span class="font-bold text-gray-900"
                    >'{{ product.title }}'</span
                >
                card.
            </div>

            <div
                class="flex flex-col md:flex-row items-center md:items-start gap-12"
            >
                <!-- Score Summary -->
                <div class="text-center md:text-left">
                    <div class="text-6xl font-black text-gray-900 mb-2">
                        {{ averageRating }}
                    </div>
                    <div class="flex gap-1 mb-2">
                        <template v-for="i in 5" :key="i">
                            <svg
                                class="w-5 h-5"
                                :class="[
                                    Math.round(averageRating) >= i
                                        ? 'text-pink-500 fill-current'
                                        : 'text-gray-200',
                                ]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.196-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                                />
                            </svg>
                        </template>
                    </div>
                    <div class="text-sm text-gray-400">
                        Based on {{ product.reviews?.length || 0 }} reviews
                    </div>
                </div>

                <div class="flex-1 max-w-md w-full space-y-3">
                    <div
                        v-for="star in [5, 4, 3, 2, 1]"
                        :key="star"
                        class="flex items-center gap-4 group"
                    >
                        <span class="text-sm font-bold text-gray-500 w-4">{{
                            star
                        }}</span>
                        <div
                            class="shrink-0 w-1.5 h-1.5 rounded-full bg-pink-500"
                        ></div>
                        <div
                            class="flex-1 h-1 bg-gray-100 rounded-full overflow-hidden"
                        >
                            <div
                                class="h-full bg-pink-500 transition-all duration-500"
                                :style="{
                                    width: getRatingPercentage(star) + '%',
                                }"
                            ></div>
                        </div>
                        <span class="text-sm text-gray-400 w-8"
                            >{{ getRatingPercentage(star) }}%</span
                        >
                    </div>
                </div>

                <!-- Write Review Button -->
                <div class="flex items-center">
                    <button
                        @click="showReviewForm = true"
                        class="inline-flex items-center gap-2 bg-[#df1172] hover:bg-[#c61065] text-white font-bold px-7 py-3 rounded-2xl transition-all duration-200 shadow-lg shadow-pink-100/50 group"
                    >
                        <svg
                            class="w-5 h-5 transition-transform group-hover:rotate-12"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                            />
                        </svg>
                        Write a Review
                    </button>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="mt-16 space-y-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6">
                    Latest Reviews
                </h3>

                <div v-if="product.reviews?.length" class="space-y-6">
                    <div
                        v-for="review in product.reviews"
                        :key="review.id"
                        class="bg-gray-50/50 rounded-3xl p-6 md:p-8 border border-gray-100 transition-all hover:bg-white hover:shadow-xl hover:shadow-gray-100/50"
                    >
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <div class="flex gap-1 mb-2">
                                    <svg
                                        v-for="i in 5"
                                        :key="i"
                                        class="w-4 h-4"
                                        :class="[
                                            review.rating >= i
                                                ? 'text-pink-500 fill-current'
                                                : 'text-gray-200',
                                        ]"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.27 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"
                                        />
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900">
                                    {{ review.title }}
                                </h4>
                            </div>
                            <span class="text-sm text-gray-400">
                                {{
                                    new Date(
                                        review.created_at,
                                    ).toLocaleDateString("en-US", {
                                        month: "long",
                                        day: "numeric",
                                        year: "numeric",
                                    })
                                }}
                            </span>
                        </div>
                        <p class="text-gray-600 mb-4 italic">
                            "{{ review.description }}"
                        </p>

                        <!-- Review Images -->
                        <div
                            v-if="review.image && review.image.length > 0"
                            class="flex flex-wrap gap-3 mb-6"
                        >
                            <div
                                v-for="(img, idx) in review.image"
                                :key="idx"
                                class="w-20 h-20 rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-md transition-shadow cursor-zoom-in"
                            >
                                <img
                                    :src="imageBaseUrl + img"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center text-pink-500 font-bold text-xs"
                            >
                                {{
                                    review.reviewer_name
                                        ?.charAt(0)
                                        .toUpperCase() || "A"
                                }}
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{
                                review.reviewer_name
                            }}</span>
                            <span
                                v-if="review.user_id"
                                class="text-[10px] bg-green-100 text-green-600 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider"
                                >Verified Purchase</span
                            >
                        </div>
                    </div>
                </div>

                <div
                    v-else
                    class="text-center py-12 bg-gray-50 rounded-3xl border border-dashed border-gray-200"
                >
                    <div class="mb-4">
                        <svg
                            class="w-12 h-12 text-gray-300 mx-auto"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                            />
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium">
                        No reviews yet. Be the first to share your experience!
                    </p>
                </div>
            </div>
        </div>

        <!-- Form View -->
        <div v-else>
            <h2 class="text-3xl font-black text-gray-900 mb-1">
                Write a Review
            </h2>
            <p class="text-sm text-gray-500 mb-8">
                Share your thoughts on the "{{ product.title }}" greeting card.
            </p>

            <form
                @submit.prevent="submitReview"
                class="bg-white rounded-3xl p-8 border border-gray-100 shadow-xl shadow-gray-100/50 space-y-8"
            >
                <!-- Rating -->
                <div ref="ratingContainer">
                    <label class="block text-sm font-bold text-gray-900 mb-3"
                        >Your Rating*</label
                    >
                    <div class="flex gap-2">
                        <button
                            type="button"
                            v-for="i in 5"
                            :key="i"
                            @mouseover="starHover = i"
                            @mouseleave="starHover = 0"
                            @click="reviewForm.rating = i"
                            class="transition-transform active:scale-90"
                        >
                            <svg
                                class="w-8 h-8"
                                :class="[
                                    (starHover || reviewForm.rating) >= i
                                        ? 'text-pink-500 fill-current'
                                        : 'text-gray-200',
                                ]"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.27 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"
                                />
                            </svg>
                        </button>
                    </div>
                    <div
                        v-if="reviewForm.errors.rating"
                        class="text-xs text-red-500 mt-1"
                    >
                        {{ reviewForm.errors.rating }}
                    </div>
                </div>

                <!-- Review Title -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3"
                        >Review Title*</label
                    >
                    <input
                        v-model="reviewForm.title"
                        type="text"
                        placeholder="e.g., Beautiful Card!"
                        class="w-full bg-gray-50 border-gray-100 rounded-xl px-5 py-4 text-gray-900 placeholder:text-gray-400 focus:ring-pink-500 focus:border-pink-500 transition-all"
                        required
                    />
                    <div
                        v-if="reviewForm.errors.title"
                        class="text-xs text-red-500 mt-1"
                    >
                        {{ reviewForm.errors.title }}
                    </div>
                </div>

                <!-- Your Review -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3"
                        >Your Review*</label
                    >
                    <textarea
                        v-model="reviewForm.content"
                        rows="5"
                        placeholder="Tell us more about your experience..."
                        class="w-full bg-gray-50 border-gray-100 rounded-xl px-5 py-4 text-gray-900 placeholder:text-gray-400 focus:ring-pink-500 focus:border-pink-500 transition-all resize-none"
                        required
                    ></textarea>
                    <div
                        v-if="reviewForm.errors.content"
                        class="text-xs text-red-500 mt-1"
                    >
                        {{ reviewForm.errors.content }}
                    </div>
                </div>

                <!-- Photo Upload -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3"
                        >Upload Photos (Optional)</label
                    >
                    <input
                        type="file"
                        multiple
                        ref="fileInput"
                        class="hidden"
                        accept="image/*"
                        @change="handleImageUpload"
                    />
                    <div
                        @click="fileInput.click()"
                        class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center hover:border-pink-500 hover:bg-pink-50 transition-all cursor-pointer group"
                    >
                        <div
                            class="bg-gray-100 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-pink-100"
                        >
                            <svg
                                class="w-6 h-6 text-gray-400 group-hover:text-pink-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"
                                />
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-600 mb-1">
                            Click to upload multiple images
                        </p>
                        <p
                            class="text-xs text-gray-400 uppercase tracking-widest"
                        >
                            PNG, JPG or GIF (MAX. 5MB each)
                        </p>
                    </div>

                    <!-- Image Previews -->
                    <div
                        v-if="imagePreviews.length > 0"
                        class="grid grid-cols-4 sm:grid-cols-6 gap-4 mt-6"
                    >
                        <div
                            v-for="(preview, index) in imagePreviews"
                            :key="index"
                            class="relative aspect-square rounded-xl overflow-hidden border border-gray-100 shadow-sm group"
                        >
                            <img
                                :src="preview"
                                class="w-full h-full object-cover"
                            />
                            <button
                                type="button"
                                @click="removeImage(index)"
                                class="absolute top-1 right-1 bg-white/90 text-red-500 p-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity shadow-sm hover:bg-red-50"
                            >
                                <svg
                                    class="w-3 h-3"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Your Name -->
                <div>
                    <label class="block text-sm font-bold text-gray-900 mb-3"
                        >Your Name*</label
                    >
                    <input
                        v-model="reviewForm.name"
                        type="text"
                        placeholder="Enter your name"
                        class="w-full bg-gray-50 border-gray-100 rounded-xl px-5 py-4 text-gray-900 placeholder:text-gray-400 focus:ring-pink-500 focus:border-pink-500 transition-all"
                        required
                    />
                    <div
                        v-if="reviewForm.errors.name"
                        class="text-xs text-red-500 mt-1"
                    >
                        {{ reviewForm.errors.name }}
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-4 pt-4">
                    <button
                        type="button"
                        @click="showReviewForm = false"
                        class="px-8 py-3.5 border-2 border-pink-500 text-pink-500 font-bold rounded-2xl hover:bg-pink-50 transition-all active:scale-95"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        :disabled="reviewForm.processing"
                        class="px-8 py-3.5 bg-pink-600 text-white font-bold rounded-2xl hover:bg-pink-700 transition-all active:scale-95 flex items-center gap-2 shadow-lg shadow-pink-100 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <svg
                            v-if="!reviewForm.processing"
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="3"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>
                        <svg
                            v-else
                            class="animate-spin h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        {{
                            reviewForm.processing
                                ? "Submitting..."
                                : "Submit Review"
                        }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
