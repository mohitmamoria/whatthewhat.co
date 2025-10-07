<script setup lang="ts">
import Shop from '@/layouts/Shop.vue';
import AboutBook from '@/partials/AboutBook.vue';
import BookVariantsV2 from '@/partials/BookVariantsV2.vue';
import GoodiesV1 from '@/partials/GoodiesV1.vue';

var props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Shop>
        <AboutBook></AboutBook>

        <!-- <Goodies></Goodies> -->
        <GoodiesV1></GoodiesV1>

        <BookVariantsV2 :variants="product.variants"></BookVariantsV2>

        <!-- <BookVariants :variants="product.variants"></BookVariants> -->

        <div class="bg-white">
            <div class="px-6 py-24 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="font-serif text-4xl font-semibold tracking-tight text-balance text-gray-900 sm:text-5xl">Thank You!</h2>
                    <p class="mx-auto mt-6 max-w-xl font-serif text-lg/8 text-pretty text-gray-600">
                        Buying this book doesnt just support us—it fuels the hope that curiosity can light up the world again.
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
