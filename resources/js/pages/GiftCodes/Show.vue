<script setup lang="ts">
import Narrow from '@/layouts/Narrow.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
    giftCode: {
        type: Object,
        required: true,
    },
});

const form = useForm({});

const checkout = () => {
    form.post(route('gift_code.checkout', { gift: props.giftCode.gift.name, giftCode: props.giftCode.name }));
};
</script>

<template>
    <Head :title="`A gift by ${giftCode.gift.gifter.name}`"></Head>
    <Narrow>
        <div class="relative isolate px-6 lg:px-8">
            <div class="mx-auto max-w-2xl">
                <div class="text-center">
                    <h1 class="text-2xl font-semibold tracking-tight text-balance text-gray-900 sm:text-3xl">🎉 Congratulations!</h1>

                    <hr class="mt-12 border-gray-300" />

                    <div class="bg-white py-12 font-serif">
                        <p>
                            We have reserved a gifted book for you for the <span class="font-bold underline">next five minutes</span>. Complete your
                            checkout to claim it, or it will be given to the next person in queue.
                        </p>
                        <p class="mt-8" v-if="!giftCode.gift.is_shipping_covered">
                            Please note that while the book is paid for by {{ giftCode.gift.gifter.name }}, shipping charges will be applied at
                            checkout.
                        </p>
                    </div>

                    <div v-if="giftCode.gift.has_received_gift">You have already received a gift. Please check your email for details.</div>
                    <div v-else>
                        <form @submit.prevent="checkout">
                            <button
                                type="submit"
                                class="mt-4 rounded-md bg-pink-600 px-2.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-pink-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-700"
                                :disabled="form.processing"
                            >
                                Accept your gift &rarr;
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Narrow>
</template>
