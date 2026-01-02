<script setup>
import PlayerTopBar from '@/partials/PlayerTopBar.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <div>
        <Head>
            <title>QOTD - daily quiz game</title>
            <meta name="description" content="Play the daily quiz game and test your knowledge with QOTD." />
        </Head>
        <div class="relative isolate mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
            <div class="mx-auto max-w-xl">
                <PlayerTopBar></PlayerTopBar>

                <header class="mb-12 text-center">
                    <Link :href="route('qotd.index')">
                        <img src="/images/qotd/qotd-logo-vertical.svg" alt="QOTD Logo" class="mx-auto mt-6 h-10 w-auto" />
                    </Link>
                </header>
                <!-- Content goes here -->
                <slot></slot>
            </div>
        </div>
    </div>
</template>
