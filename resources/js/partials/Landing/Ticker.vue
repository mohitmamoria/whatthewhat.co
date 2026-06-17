<script setup lang="ts">
import Highlight from '@/partials/Landing/Highlight.vue';
import ReviewModal from '@/partials/Landing/ReviewModal.vue';
import SectionBadge from '@/partials/Landing/SectionBadge.vue';
import { computed, ref } from 'vue';

const props = defineProps({
    reviews: {
        type: Array,
        default: () => [],
    },
});

const colors = ['bg-lime', 'bg-sun', 'bg-sky', 'bg-grape', 'bg-bubble'];
const PREVIEW_LENGTH = 140;
const TICKER_REVIEW_LIMIT = 20;

// Must match .ticker-card's flex-basis and .ticker-track's gap below.
const CARD_WIDTH = 320;
const CARD_GAP = 24;

// Tuned to match the pace that already looked right at ~19 reviews / 60s:
// 60s / 19 cards ≈ 3.16s per card (rounded to 3.2 for a clean constant).
const SECONDS_PER_CARD = 3.2;

const tickerReviews = computed(() => props.reviews.slice(0, TICKER_REVIEW_LIMIT));

// Duplicated for the seamless loop.
const cards = computed(() => [...tickerReviews.value, ...tickerReviews.value]);

const animationDuration = computed(() => `${(tickerReviews.value.length * SECONDS_PER_CARD).toFixed(2)}s`);

// Computed in pixels (rather than translateX(-50%) of a `width: max-content`
// track) because mobile WebKit miscalculates the intrinsic width of very wide
// flex rows with many duplicated children, landing the loop point short and
// leaving a blank gap for the rest of the cycle.
const tickerDistance = computed(() => `${tickerReviews.value.length * (CARD_WIDTH + CARD_GAP) - CARD_GAP}px`);

const stars = (rating: number): string => '⭐'.repeat(rating);

const isTruncated = (quote: string): boolean => quote.length > PREVIEW_LENGTH;

const preview = (quote: string): string => (isTruncated(quote) ? `${quote.slice(0, PREVIEW_LENGTH).trimEnd()}…` : quote);

const selectedReview = ref(null);
</script>

<template>
    <section class="py-12 md:py-16">
        <div class="mx-auto max-w-6xl px-5">
            <div class="mx-auto max-w-2xl text-center">
                <SectionBadge color="bg-bubble" rotation="-rotate-1">Readers love it</SectionBadge>
                <h2 class="mt-5 font-fraunces text-4xl leading-tight font-semibold tracking-tight md:text-5xl">
                    What people are <Highlight color="#a8d8ff">saying</Highlight>
                </h2>
            </div>
        </div>

        <!-- Full-bleed ticker -->
        <div class="ticker-wrap mt-12 py-4">
            <div class="ticker-track" :style="{ '--ticker-duration': animationDuration, '--ticker-distance': tickerDistance }">
                <figure
                    v-for="(review, index) in cards"
                    :key="index"
                    class="ticker-card rounded-3xl border-2 border-ink p-6 shadow-stickersm"
                    :class="colors[index % colors.length]"
                >
                    <p class="text-sm leading-none">{{ stars(review.rating) }}</p>
                    <p v-if="review.title" class="mt-3 font-fraunces text-lg leading-snug font-semibold">{{ review.title }}</p>
                    <blockquote class="mt-2 font-fraunces text-base leading-snug font-medium break-words italic">
                        "{{ preview(review.quote) }}"
                    </blockquote>
                    <button
                        v-if="isTruncated(review.quote)"
                        type="button"
                        class="mt-1 text-xs font-bold underline decoration-2 underline-offset-2 hover:no-underline"
                        @click="selectedReview = review"
                    >
                        Read more
                    </button>
                    <figcaption class="mt-4 text-[0.65rem] font-bold tracking-wide uppercase">{{ review.author }} · Verified reader</figcaption>
                </figure>
            </div>
        </div>

        <ReviewModal :review="selectedReview" @close="selectedReview = null" />
    </section>
</template>

<style scoped>
.ticker-wrap {
    overflow: hidden;
}

.ticker-track {
    display: flex;
    gap: 1.5rem;
    width: max-content;
    animation: ticker var(--ticker-duration, 60s) linear infinite;
}

.ticker-track:hover {
    animation-play-state: paused;
}

@keyframes ticker {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(calc(-1 * var(--ticker-distance, 50%)));
    }
}

.ticker-card {
    flex: 0 0 320px;
}
</style>
