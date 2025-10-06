<script setup lang="ts">
import Shop from '@/layouts/Shop.vue';
import BookVariants from '@/partials/BookVariants.vue';
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
        <article v-html="props.product.description_html" class="prose mb-4"></article>

        <!-- <Goodies></Goodies> -->
        <GoodiesV1></GoodiesV1>

        <BookVariants :variants="product.variants"></BookVariants>

        <div class="bg-white">
            <div class="px-6 py-24 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-4xl font-semibold tracking-tight text-balance text-gray-900 sm:text-5xl">25 November 2025</h2>
                    <p class="mx-auto mt-6 max-w-xl text-lg/8 text-pretty text-gray-600">
                        The book releases in November, and the shipping starts on Nov 19, so that it reaches in your hands on time.
                    </p>
                </div>
            </div>
        </div>
    </Shop>
</template>
