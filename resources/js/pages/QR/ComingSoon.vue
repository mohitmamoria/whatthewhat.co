<script setup>
import Narrow from '@/layouts/Narrow.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const loggedInPlayer = usePage().props.auth.player;

const props = defineProps({
    intended: {
        type: String,
        default: null,
    },
});

const form = useForm({
    page: props.intended,
});

const subscribe = () => {
    form.post(route('qr.coming_soon.subscribe'), {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>

<template>
    <Narrow>
        <div class="mt-12 bg-white py-12">
            <div class="mx-auto max-w-7xl lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <p class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl lg:text-balance">Coming Soon</p>
                    <p class="mt-6 text-lg/8 text-gray-600">This page will become available on 5 December 2025.</p>
                    <div v-if="!loggedInPlayer" class="mt-10 flex items-center justify-center gap-x-6">
                        <Link
                            :href="route('auth.player.login', { next: route('qr.coming_soon', { page: props.intended }) })"
                            class="rounded-md bg-gray-700 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-gray-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800"
                            >Submit your WhatsApp number to get notified &rarr;</Link
                        >
                    </div>
                    <div v-else>
                        <form @submit.prevent="subscribe">
                            <button
                                type="submit"
                                class="mt-4 rounded-md bg-pink-600 px-2.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-pink-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-700 disabled:opacity-50"
                                :disabled="form.processing || form.wasSuccessful"
                            >
                                Get Notified &rarr;
                            </button>

                            <p v-if="form.wasSuccessful" class="mt-2 text-sm text-gray-600">
                                You will be notified via WhatsApp when this page is available.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </Narrow>
</template>
