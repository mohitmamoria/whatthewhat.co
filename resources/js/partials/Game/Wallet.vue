<script setup>
import { TrophyIcon } from '@heroicons/vue/16/solid';

const props = defineProps({
    wallet: {
        type: Object,
        default: null,
    },
});

const stats = [
    { name: 'Balance', value: props.wallet.balance, unit: props.wallet.currency_symbol },
    { name: 'Lifetime Earned', value: props.wallet.lifetime_earned, unit: props.wallet.currency_symbol },
    { name: 'Lifetime Spent', value: props.wallet.lifetime_spent, unit: props.wallet.currency_symbol },
];
</script>

<template>
    <!-- Leaderboards -->
    <div class="mb-12 rounded-md bg-blue-50 p-4">
        <div class="flex">
            <div class="shrink-0">
                <TrophyIcon class="size-5 text-blue-400" aria-hidden="true" />
            </div>
            <div class="ml-3 flex-1 md:flex md:justify-between">
                <p class="text-sm text-blue-700">Leaderboards are coming soon. Stay tuned.</p>
            </div>
        </div>
    </div>

    <div class="border-b border-gray-200 pb-5">
        <h3 class="text-base font-semibold text-gray-900">Curiosity Points</h3>
    </div>
    <div class="mb-12 bg-white">
        <div class="mx-auto max-w-7xl">
            <div class="grid grid-cols-1 gap-px bg-gray-900/5 sm:grid-cols-3">
                <div v-for="stat in stats" :key="stat.name" class="bg-white px-4 py-6 sm:px-6 lg:px-8">
                    <p class="text-sm/6 font-medium text-gray-500">{{ stat.name }}</p>
                    <p class="mt-2 flex items-baseline gap-x-2">
                        <span class="text-xl font-semibold tracking-tight text-gray-900">{{ stat.value }}</span>
                        <span v-if="stat.unit" class="text-sm text-gray-500">{{ stat.unit }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
