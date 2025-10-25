<script setup lang="ts">
import Narrow from '@/layouts/Narrow.vue';
import AboutBookMinimal from '@/partials/AboutBookMinimal.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    gift: {
        type: Object,
        required: true,
    },
});

const loggedInPlayer = usePage().props.auth.player;

const form = useForm({});

const reserve = () => {
    form.post(route('gift.reserve', { gift: props.gift.name }));
};
</script>

<template>
    <Head :title="`A gift by ${gift.gifter_name}`"></Head>
    <Narrow>
        <div class="relative isolate px-6 lg:px-8">
            <div class="mx-auto max-w-2xl">
                <AboutBookMinimal />
                <div class="text-center">
                    <h1 class="text-2xl font-semibold tracking-tight text-balance text-gray-900 sm:text-3xl">
                        🎁 Gift of curiosity by <br />
                        <span class="font-serif text-5xl leading-relaxed">{{ gift.gifter_name }}</span>
                    </h1>
                    <p class="mt-8 font-serif text-lg font-medium text-pretty text-gray-900 sm:text-xl/8">
                        This gift of curiosity will make the world a more curious place. Thank you, {{ gift.gifter_name }}!
                    </p>
                    <p class="mt-4 font-serif text-lg font-medium text-pretty text-gray-900 sm:text-xl/8" v-if="gift.is_shipping_covered">
                        ❤️ Shipping charges are also covered by {{ gift.gifter_name }}.
                    </p>

                    <hr class="mt-12 border-gray-300" />

                    <div class="bg-white py-12">
                        <p class="text-base/7 text-gray-600">Available</p>
                        <p class="order-first text-3xl font-semibold tracking-tight text-gray-900 sm:text-5xl">
                            {{ gift.ready_count }} <span class="text-xl font-normal text-gray-600">/ {{ gift.total_count }}</span>
                        </p>
                    </div>

                    <div v-if="!loggedInPlayer" class="mt-10 flex items-center justify-center gap-x-6">
                        <Link
                            :href="route('auth.player.login', { next: route('gift.show', { gift: gift.name }) })"
                            class="rounded-md bg-gray-800 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-gray-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800"
                            >Verify yourself to receive your gift &rarr;</Link
                        >
                    </div>
                    <div v-else-if="gift.can_receive_gift">
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
                    <div v-else>Seems like you have already purchased the book or received it as a gift. Please check your email.</div>
                </div>
            </div>
        </div>
    </Narrow>
</template>
