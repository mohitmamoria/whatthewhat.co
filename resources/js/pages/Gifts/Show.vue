<script setup lang="ts">
import Narrow from '@/layouts/Narrow.vue';
import { Head } from '@inertiajs/vue3';

var props = defineProps({
    gift: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head :title="`A gift by ${gift.gifter.name}`"></Head>
    <Narrow>
        <div class="relative isolate px-6 lg:px-8">
            <div class="mx-auto max-w-2xl">
                <div class="mb-8 flex justify-center">
                    <div
                        class="relative flex flex-col items-center gap-1 rounded-full px-6 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20 sm:flex-row"
                    >
                        Want to give the gift of curiosity?
                        <a :href="route('shop.gift')" class="font-semibold text-purple-600"
                            ><span class="absolute inset-0" aria-hidden="true" />Give here <span aria-hidden="true">&rarr;</span></a
                        >
                    </div>
                </div>
                <div class="text-center">
                    <h1 class="text-2xl font-semibold tracking-tight text-balance text-gray-900 sm:text-3xl">
                        Gift of curiosity by <br />
                        <span class="text-5xl">{{ gift.gifter.name }}</span>
                    </h1>
                    <p class="mt-8 text-lg font-medium text-pretty text-gray-700 sm:text-xl/8">
                        Includes {{ gift.quantity }} books (+ Good Good Goodies) to make the world a more curious place.
                    </p>
                    <p class="mt-4 text-lg font-medium text-pretty text-gray-700 sm:text-xl/8" v-if="gift.is_shipping_covered">
                        ❤️ Shipping is also covered by {{ gift.gifter.name }}.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a
                            href="#"
                            class="rounded-md bg-purple-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-purple-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600"
                            >Verify yourself to receive your gift</a
                        >
                    </div>
                </div>
            </div>
        </div>
    </Narrow>
</template>
