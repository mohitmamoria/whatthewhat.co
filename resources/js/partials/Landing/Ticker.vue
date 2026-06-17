<script setup lang="ts">
import { computed } from 'vue';
import Highlight from '@/partials/Landing/Highlight.vue';
import SectionBadge from '@/partials/Landing/SectionBadge.vue';

const props = defineProps({
    reviews: {
        type: Array,
        default: () => [],
    },
});

const colors = ['bg-lime', 'bg-sun', 'bg-sky', 'bg-grape', 'bg-bubble'];

// Duplicated for the seamless -50% loop.
const cards = computed(() => [...props.reviews, ...props.reviews]);

const stars = (rating: number): string => '⭐'.repeat(rating);
</script>

<template>
    <section class="py-12 md:py-16">
        <div class="mx-auto max-w-6xl px-5">
            <div class="mx-auto max-w-2xl text-center">
                <SectionBadge color="bg-bubble" rotation="-rotate-1">Readers love it</SectionBadge>
                <h2 class="mt-5 font-fraunces text-4xl font-semibold tracking-tight leading-tight md:text-5xl">
                    What people are <Highlight color="#a8d8ff">saying</Highlight>
                </h2>
            </div>
        </div>

        <!-- Full-bleed ticker -->
        <div class="ticker-wrap mt-12 py-4">
            <div class="ticker-track">
                <figure
                    v-for="(review, index) in cards"
                    :key="index"
                    class="ticker-card rounded-3xl border-2 border-ink p-6 shadow-stickersm"
                    :class="colors[index % colors.length]"
                >
                    <p class="text-sm leading-none">{{ stars(review.rating) }}</p>
                    <p v-if="review.title" class="mt-3 font-fraunces text-lg font-semibold leading-snug">{{ review.title }}</p>
                    <blockquote class="mt-2 font-fraunces text-base font-medium italic leading-snug">"{{ review.quote }}"</blockquote>
                    <figcaption class="mt-4 text-[0.65rem] font-bold tracking-wide uppercase">{{ review.author }} · Verified reader</figcaption>
                </figure>
            </div>
        </div>
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
    animation: ticker 60s linear infinite;
}

.ticker-track:hover {
    animation-play-state: paused;
}

@keyframes ticker {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.ticker-card {
    flex: 0 0 320px;
}
</style>
