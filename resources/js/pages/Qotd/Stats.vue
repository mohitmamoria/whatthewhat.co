<script setup>
import Qotd from '@/layouts/Qotd.vue';
import { useClipboard } from '@vueuse/core';

const props = defineProps({
    qotd_game: {
        type: Object,
        required: true,
    },
});

const stats = [
    { name: 'Current Streak', value: `${props.qotd_game.current_streak}`, subtext: `Longest Streak: ${props.qotd_game.longest_streak}` },
    { name: 'Total Answered', value: `${props.qotd_game.total_answered}`, subtext: `Played: ${props.qotd_game.total_attempted}` },
    { name: 'Win %', value: `${props.qotd_game.answered_percent}`, subtext: `Avg time taken: ${props.qotd_game.average_time_taken}` },
];

const { text, copy, copied, isSupported } = useClipboard();
</script>

<template>
    <Qotd>
        <div>
            <h3 class="text-base font-semibold text-gray-900">Your QOTD Stats</h3>
            <dl class="mt-5 grid grid-cols-1 divide-gray-200 overflow-hidden rounded-lg bg-white shadow-sm md:grid-cols-3 md:divide-x md:divide-y-0">
                <div v-for="item in stats" :key="item.name" class="px-4 py-5 sm:p-6">
                    <dt class="text-base font-normal text-gray-900">{{ item.name }}</dt>
                    <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                        <div class="flex items-baseline text-2xl font-semibold text-pink-600">
                            {{ item.value }}
                        </div>
                    </dd>
                    <p class="text-sm font-medium text-gray-500">{{ item.subtext }}</p>
                </div>
            </dl>
        </div>

        <div class="mt-12 overflow-hidden rounded-lg bg-white shadow-sm">
            <div class="px-4 py-5 sm:p-6">
                <h1 class="text-xl font-bold">Share curiosity with your friends</h1>
                <p class="prose mt-2">Send the following message to your friends so that they too can play QOTD.</p>
                <p class="mt-2 rounded border border-dashed border-gray-400 p-2" v-html="$page.props.auth.player.qotd_referral_message_html"></p>

                <div v-if="isSupported">
                    <button
                        @click="copy($page.props.auth.player.qotd_referral_message)"
                        class="mt-4 inline-flex items-center rounded-md bg-pink-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-pink-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600"
                    >
                        <span v-if="!copied">Copy</span>
                        <span v-else>Copied!</span>
                    </button>
                </div>
            </div>
        </div>
    </Qotd>
</template>
