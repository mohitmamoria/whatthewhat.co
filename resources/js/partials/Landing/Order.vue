<script setup lang="ts">
import Highlight from '@/partials/Landing/Highlight.vue';
import OrderCard from '@/partials/Landing/OrderCard.vue';
import SectionBadge from '@/partials/Landing/SectionBadge.vue';

defineProps({
    variants: {
        type: Array,
        default: () => [],
    },
});

const badges: Record<string, string> = {
    'wtw-book-solo': 'Best value',
    'wtw-book-calendar': 'Everything bundle',
};

const cutoutPrice: Record<string, number> = {
    'wtw-book-solo': 399,
    'wtw-book-calendar': 899,
};
</script>

<template>
    <section id="order" class="mx-auto max-w-6xl scroll-mt-24 px-5 py-12 md:py-16">
        <div class="mx-auto max-w-2xl text-center">
            <SectionBadge color="bg-lime" rotation="-rotate-2">Signed first edition</SectionBadge>
            <h2 class="mt-5 font-fraunces text-4xl leading-tight font-semibold tracking-tight md:text-5xl">
                A signed copy — plus a <Highlight color="#a8d8ff">free bookmark</Highlight>
            </h2>
            <p class="mx-auto mt-6 max-w-xl text-base leading-relaxed text-muted md:text-lg">
                Every copy in this run is hand-signed by the author and ships with a letterpress bookmark. Priced to fit any pocket, students
                included.
            </p>
        </div>

        <div class="mt-12 flex flex-col gap-8 md:flex-row md:items-stretch md:justify-center">
            <template v-for="variant in variants" :key="variant.id">
                <OrderCard
                    v-if="!variant.sku.endsWith('duo')"
                    :variant="variant"
                    :badge="badges[variant.sku] ?? null"
                    :cutout-price="cutoutPrice[variant.sku] ?? null"
                />
            </template>
        </div>

        <p class="mt-6 text-center text-xs font-bold tracking-wide text-muted uppercase">Free shipping across India · Cash on delivery available</p>
    </section>
</template>
