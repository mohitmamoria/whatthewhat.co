<script setup>
import GifterOnLeaderboard from '@/partials/GifterOnLeaderboard.vue';

const props = defineProps({
    gifts: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <div class="bg-white py-12">
        <div class="mx-auto max-w-7xl lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-sm font-semibold text-indigo-600">#TeamCuriosity</h2>
                <p class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl lg:text-balance">Top Gifters</p>
                <p class="mt-6 text-lg/8 text-balance text-gray-600">
                    Thank you to these amazing people who have gifted curiosity to others! Your generosity is inspiring.
                </p>
            </div>
            <div class="mt-6 bg-white px-12 shadow-sm sm:rounded-lg">
                <ul role="list" class="divide-y divide-gray-200 xl:col-span-3">
                    <li v-for="(gift, index) in gifts" :key="gift.name">
                        <GifterOnLeaderboard :gift="gift" :rank="index + 1"></GifterOnLeaderboard>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
