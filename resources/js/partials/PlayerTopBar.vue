<script setup>
import { Link, usePage } from '@inertiajs/vue3';
const loggedInPlayer = usePage().props.auth.player;
</script>

<template>
    <div v-if="loggedInPlayer" class="flex items-center justify-between">
        <h1 class="flex items-center gap-x-2.5">
            Hello, {{ loggedInPlayer.name }}!
            <Link :href="route('game.index')" class="text-xs text-gray-900 hover:underline">
                <span
                    class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-gray-900 inset-ring inset-ring-gray-200"
                >
                    🧠 {{ loggedInPlayer.wallet.balance }} {{ loggedInPlayer.wallet.currency_symbol }}
                </span>
            </Link>
        </h1>
        <div class="flex items-center gap-4">
            <Link :href="route('auth.player.logout')" class="font-bold text-gray-700 hover:underline" method="post" as="button">Logout</Link>
        </div>
    </div>
</template>
