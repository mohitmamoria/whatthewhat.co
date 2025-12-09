<script setup>
import { CakeIcon, ChartBarIcon, SquaresPlusIcon } from '@heroicons/vue/20/solid';
import { Link } from '@inertiajs/vue3';

const features = [
    {
        name: 'Fun way to learn new things.',
        icon: SquaresPlusIcon,
    },
    {
        name: '100% free to play.',
        icon: CakeIcon,
    },
    {
        name: 'Compete with friends and players worldwide.',
        icon: ChartBarIcon,
    },
];
</script>

<template>
    <div class="mx-auto gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none">
        <div class="">
            <p class="mt-2 text-center font-serif text-2xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-3xl">Question Of The Day</p>
            <p class="mt-6 text-lg/8 text-gray-700">
                A daily game (100% free; no ads or paywalls) where you answer a fun trivia question to earn points and compete with other players on
                the leaderboard.
            </p>
            <dl class="mt-10 max-w-xl space-y-8 text-base/7 text-gray-600 lg:max-w-none">
                <div v-for="feature in features" :key="feature.name" class="relative pl-9">
                    <dt class="inline font-semibold text-gray-900">
                        <component :is="feature.icon" class="absolute top-1 left-1 size-5 text-indigo-600" aria-hidden="true" />
                        {{ feature.name }}
                    </dt>
                </div>
            </dl>
        </div>
        <div class="mt-12 text-center">
            <Link
                :href="route('auth.player.login', { next: route('qotd.index') })"
                class="rounded-md bg-gray-800 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-gray-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800"
                >Login using WhatsApp to play &rarr;</Link
            >
        </div>
    </div>
</template>
