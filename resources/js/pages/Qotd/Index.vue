<script setup>
import Qotd from '@/layouts/Qotd.vue';
import QotdForGuest from '@/partials/Qotd/QotdForGuest.vue';
import QotdPreGame from '@/partials/Qotd/QotdPreGame.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    question: {
        type: Object,
        required: true,
    },
    qotd_game: {
        type: Object,
        default: null,
    },
});

const loggedInPlayer = usePage().props.auth.player;

const joinForm = useForm({
    name: loggedInPlayer ? loggedInPlayer.name : '',
});
const join = () => {
    joinForm.post(route('qotd.join'));
};
</script>

<template>
    <Qotd>
        <div v-if="!loggedInPlayer" class="mt-10 flex items-center justify-center gap-x-6">
            <QotdForGuest />
        </div>
        <div v-else-if="!qotd_game">
            <p class="mb-4 text-gray-700">
                Welcome to Question of the Day (QOTD)! To start playing, please confirm your name below and join the game.
            </p>
            <form @submit.prevent="join" class="space-y-2">
                <div>
                    <div class="flex items-center justify-between">
                        <label for="name" class="block text-sm/6 font-medium text-gray-900">Confirm your name</label>
                    </div>
                    <div class="mt-2">
                        <input
                            type="text"
                            name="name"
                            id="name"
                            v-model="joinForm.name"
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-pink-600 sm:text-sm/6"
                        />
                        <p v-if="joinForm.errors.name" class="mt-2 text-sm/6 text-red-600">{{ joinForm.errors.name }}</p>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-md bg-pink-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-pink-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600"
                    >
                        Start Playing QOTD &rarr;
                    </button>
                </div>
            </form>
        </div>
        <div v-else>
            <QotdPreGame :question="question" />
        </div>
    </Qotd>
</template>
