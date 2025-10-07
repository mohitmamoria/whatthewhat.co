<script setup>
import VariantCheckout from '@/components/VariantCheckout.vue';

const props = defineProps({
    variants: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <div class="bg-white">
        <div class="mx-auto max-w-2xl py-16 lg:max-w-7xl">
            <h2 class="sr-only">Bundles</h2>

            <div class="grid grid-cols-1 gap-y-4 sm:grid-cols-2 sm:gap-x-6 sm:gap-y-10 lg:grid-cols-3 lg:gap-x-8">
                <div
                    v-for="variant in variants"
                    :key="variant.id"
                    class="group relative flex flex-col overflow-hidden rounded-lg border border-gray-200 bg-white"
                >
                    <img
                        :src="variant.image_src"
                        :alt="variant.title"
                        class="aspect-3/4 w-full bg-gray-200 object-cover group-hover:opacity-75 sm:aspect-auto sm:h-96"
                    />
                    <div class="flex flex-1 flex-col space-y-2 p-4">
                        <h3 class="text-sm font-medium text-gray-900">
                            {{ variant.title }}
                        </h3>
                        <article class="prose prose-sm" v-html="variant.description"></article>
                        <div class="flex flex-1 flex-col justify-end">
                            <VariantCheckout :variant="variant"></VariantCheckout>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
