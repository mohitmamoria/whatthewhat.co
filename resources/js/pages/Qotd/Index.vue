<script setup>
import Qotd from '@/layouts/Qotd.vue';
import QotdForGuest from '@/partials/Qotd/QotdForGuest.vue';
import QotdJoin from '@/partials/Qotd/QotdJoin.vue';
import QotdPreGame from '@/partials/Qotd/QotdPreGame.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    question: {
        type: Object,
        required: true,
    },
    qotd_game: {
        type: Object,
        default: null,
    },
    referrer: {
        type: Object,
        default: null,
    },
});

const loggedInPlayer = usePage().props.auth.player;
</script>

<template>
    <Qotd>
        <div v-if="!loggedInPlayer" class="mt-10 flex items-center justify-center gap-x-6">
            <QotdForGuest />
        </div>
        <div v-else-if="!qotd_game">
            <QotdJoin :referrer="referrer" />
        </div>
        <div v-else>
            <QotdPreGame :question="question" />
        </div>
    </Qotd>
</template>
