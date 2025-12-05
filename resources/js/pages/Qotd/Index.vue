<script setup>
import Qotd from '@/layouts/Qotd.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const loggedInPlayer = usePage().props.auth.player;

const form = useForm({});
</script>

<template>
    <Qotd>
        <div v-if="!loggedInPlayer" class="mt-10 flex items-center justify-center gap-x-6">
            <Link
                :href="route('auth.player.login', { next: route('qotd.index') })"
                class="rounded-md bg-gray-800 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-gray-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800"
                >Login using WhatsApp to play &rarr;</Link
            >
        </div>
        <div v-else>
            <form>
                <button
                    type="submit"
                    class="mt-4 rounded-md bg-pink-600 px-2.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-pink-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-700"
                    :disabled="form.processing"
                >
                    Play QOTD &rarr;
                </button>
            </form>
        </div>
    </Qotd>
</template>
