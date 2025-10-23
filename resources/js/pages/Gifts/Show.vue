<script setup lang="ts">
import Narrow from '@/layouts/Narrow.vue';
import AboutBookMinimal from '@/partials/AboutBookMinimal.vue';
import { Head, useForm } from '@inertiajs/vue3';

var props = defineProps({
    gift: {
        type: Object,
        required: true,
    },
});

const form = useForm({});

const reserve = () => {
    form.post(route('gift.reserve', { gift: props.gift.name }));
};
</script>

<template>
    <Head :title="`A gift by ${gift.gifter.name}`"></Head>
    <Narrow>
        <div class="relative isolate px-6 lg:px-8">
            <div class="mx-auto max-w-2xl">
                <AboutBookMinimal />
                <!-- <div class="mb-8 flex justify-center">
                    <div
                        class="relative flex flex-col items-center gap-1 rounded-full px-6 py-1 text-sm/6 text-gray-600 ring-1 ring-gray-900/10 hover:ring-gray-900/20 sm:flex-row"
                    >
                        Want to give the gift of curiosity?
                        <a :href="route('shop.gift')" class="font-semibold text-purple-600"
                            ><span class="absolute inset-0" aria-hidden="true" />Give here <span aria-hidden="true">&rarr;</span></a
                        >
                    </div>
                </div> -->
                <div class="text-center">
                    <h1 class="text-2xl font-semibold tracking-tight text-balance text-gray-900 sm:text-3xl">
                        🎁 Gift of curiosity by <br />
                        <span class="font-serif text-5xl leading-relaxed">{{ gift.gifter.name }}</span>
                    </h1>
                    <p class="mt-8 font-serif text-lg font-medium text-pretty text-gray-900 sm:text-xl/8">
                        This gift of curiosity will make the world a more curious place. Thank you, {{ gift.gifter.name }}!
                    </p>
                    <p class="mt-4 font-serif text-lg font-medium text-pretty text-gray-900 sm:text-xl/8" v-if="gift.is_shipping_covered">
                        ❤️ Shipping charges are also covered by {{ gift.gifter.name }}.
                    </p>

                    <hr class="mt-12 border-gray-300" />

                    <div class="bg-white py-12">
                        <p class="text-base/7 text-gray-600">Available</p>
                        <p class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                            {{ gift.ready_count }} <span class="text-xl font-normal text-gray-600">/ {{ gift.total_count }}</span>
                        </p>
                    </div>

                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a
                            href="#"
                            class="rounded-md bg-purple-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-purple-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600"
                            >Verify yourself to receive your gift</a
                        >
                    </div>

                    <form @submit.prevent="reserve">
                        <button
                            type="submit"
                            class="mt-4 rounded-md bg-pink-600 px-2.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-pink-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-700"
                            :disabled="form.processing"
                        >
                            Claim your gift &rarr;
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </Narrow>
</template>
