<script setup>
import { Link, usePage } from '@inertiajs/vue3';
const loggedInPlayer = usePage().props.auth.player;
</script>

<template>
    <div v-if="loggedInPlayer" class="flex items-center justify-between">
        <h1>Hello, {{ loggedInPlayer.name }}!</h1>
        <div class="flex items-center gap-4">
            <Link :href="route('auth.player.logout')" class="font-bold text-gray-700 hover:underline" method="post" as="button">Logout</Link>
        </div>
    </div>
</template>
