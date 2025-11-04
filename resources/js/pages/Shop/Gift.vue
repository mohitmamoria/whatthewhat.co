<script setup>
import Shop from '@/layouts/Shop.vue';
import AboutBook from '@/partials/AboutBook.vue';
import GiftVariants from '@/partials/GiftVariants.vue';
import TopGifters from '@/partials/TopGifters.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    gifts: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Shop>
        <AboutBook></AboutBook>

        <TopGifters class="mt-12" :gifts="gifts"></TopGifters>

        <div id="buy">
            <GiftVariants :variants="product.variants"></GiftVariants>
        </div>

        <div class="bg-white">
            <div class="px-6 py-24 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="font-serif text-4xl font-semibold tracking-tight text-balance text-gray-900 sm:text-5xl">Thank You!</h2>
                    <p class="mx-auto mt-6 max-w-xl font-serif text-lg/8 text-pretty text-gray-600">
                        Buying this book doesn't just support us—it fuels the hope that curiosity can light up the world again.
                    </p>
                    <p class="mx-auto mt-6 max-w-xl font-serif text-lg/8 text-pretty text-gray-600">
                        For bulk orders (100+ books), please write to us at
                        <a href="mailto:community@areypatahai.com" class="underline" target="_blank">community@areypatahai.com</a>.
                    </p>
                </div>
            </div>
        </div>
    </Shop>
</template>
