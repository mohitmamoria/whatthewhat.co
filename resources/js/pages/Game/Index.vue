<script setup>
import Game from '@/layouts/Game.vue';
import GameActivities from '@/partials/Game/GameActivities.vue';
import Wallet from '@/partials/Game/Wallet.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    wallet: {
        type: Object,
        default: null,
    },
    transactions: {
        type: Object,
        default: null,
    },
});

const loggedInPlayer = usePage().props.auth.player;
</script>

<template>
    <Game>
        <div v-if="!loggedInPlayer" class="mt-10 flex items-center justify-center gap-x-6">Not logged in</div>
        <div v-else>
            <Wallet :wallet="wallet" />
            <GameActivities :wallet="wallet" :transactions="transactions" />
        </div>
    </Game>
</template>
