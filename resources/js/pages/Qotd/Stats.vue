<script setup>
import Qotd from '@/layouts/Qotd.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    qotd_game: {
        type: Object,
        required: true,
    },
});

const loggedInPlayer = usePage().props.auth.player;

const stats = [
    { name: 'Current Streak', value: `${props.qotd_game.current_streak}`, subtext: `Longest Streak: ${props.qotd_game.longest_streak}` },
    { name: 'Total Answered', value: `${props.qotd_game.total_answered}`, subtext: `Played: ${props.qotd_game.total_attempted}` },
    { name: 'Win %', value: `${props.qotd_game.answered_percent}`, subtext: `Avg time taken: ${props.qotd_game.average_time_taken}` },
];
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
    </Qotd>
</template>
