<script setup>
import GiftVariantCheckout from '@/components/GiftVariantCheckout.vue';

const props = defineProps({
    variants: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <div class="bg-white py-12">
        <div class="mx-auto max-w-7xl lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-sm font-semibold text-indigo-600">Make the world a more curious place</h2>
                <p class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl lg:text-balance">Spread the curiosity</p>
                <p class="mt-6 text-lg/8 text-balance text-gray-600">
                    Gift curiosity; it's the only thing that multiplies when shared. A more curious world is always a better place to grow up in.
                </p>
            </div>

            <div class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <ul role="list" class="divide-y divide-gray-200 xl:col-span-3">
                        <li
                            v-for="(variant, index) in variants"
                            :key="variant.id"
                            class="flex flex-col gap-10 py-12 first:pt-0 last:pb-0 sm:flex-row"
                        >
                            <img
                                class="w-full flex-none rounded object-cover outline-1 -outline-offset-1 outline-black/5 sm:inline-block sm:w-32"
                                :src="variant.image_src"
                                :alt="variant.title"
                            />
                            <div class="max-w-xl flex-auto">
                                <h3 class="text-lg/8 font-semibold tracking-tight text-gray-900">{{ variant.title }}</h3>
                                <p class="font-xs font-bold text-gray-700">₹{{ variant.price }} only</p>
                                <article class="prose prose-sm mt-2" v-html="variant.description"></article>
                                <GiftVariantCheckout class="mt-8" :variant="variant"></GiftVariantCheckout>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
