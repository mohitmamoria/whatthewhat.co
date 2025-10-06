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
    </Shop>
</template>
