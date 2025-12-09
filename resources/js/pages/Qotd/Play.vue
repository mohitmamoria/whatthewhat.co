<script setup>
import Qotd from '@/layouts/Qotd.vue';
import { CheckCircleIcon } from '@heroicons/vue/20/solid';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    attempt: {
        type: Object,
        required: true,
    },
});

const loggedInPlayer = usePage().props.auth.player;

const form = useForm({
    answer: props.attempt.answer,
});

const timeout = () => {
    form.post(route('qotd.timeout', { attempt: props.attempt.name }));
};
const timeLeft = ref(15);
const timer = setInterval(() => {
    if (timeLeft.value > 0) {
        timeLeft.value -= 1;
    } else {
        clearInterval(timer);
        timeout();
    }
}, 1000);
if (props.attempt.is_completed) {
    timeLeft.value = 0;
    clearInterval(timer);
}

const barLength = computed(() => {
    return 100 - ((15 - timeLeft.value) / 15) * 100;
});

const submit = () => {
    form.post(route('qotd.answer', { attempt: props.attempt.name }), {
        onFinish: () => {
            clearInterval(timer);
        },
    });
};
</script>

<template>
    <Qotd>
        <div v-if="!attempt.is_completed">
            <div class="mb-4 text-center">
                <span class="rounded-full bg-pink-600 p-2 px-4 text-xl font-bold text-white">{{ timeLeft > 0 ? timeLeft : 'TIMES UP!' }}</span>
            </div>
            <div class="my-2 overflow-hidden rounded-full bg-gray-200">
                <div class="h-2 rounded-full bg-pink-600" :style="{ width: barLength + '%' }"></div>
            </div>
        </div>
        <form class="space-y-2" @submit.prevent="submit">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="px-4 py-5 sm:p-6">
                    <article class="pros mb-8 whitespace-pre-wrap" v-html="attempt.question.body_html"></article>

                    <div class="mt-2 grid grid-cols-1 gap-3">
                        <label
                            v-for="(option, index) in attempt.question.options"
                            :key="index"
                            :aria-label="option"
                            class="group relative flex items-center justify-center rounded-md border border-gray-300 bg-white p-3 has-checked:border-gray-300 has-checked:bg-gray-300 has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-gray-300 has-disabled:border-gray-400 has-disabled:opacity-60"
                        >
                            <input
                                type="radio"
                                name="option"
                                v-model="form.answer"
                                :value="index"
                                :disabled="attempt.is_completed"
                                class="absolute inset-0 appearance-none focus:outline-none disabled:cursor-not-allowed"
                            />
                            <span class="text-sm font-medium text-gray-900">{{ option }}</span>
                        </label>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6" v-if="!attempt.is_completed">
                    <div>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="flex w-full justify-center rounded-md bg-pink-600 px-3 py-1.5 text-sm leading-6 font-semibold text-white shadow-sm hover:bg-pink-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600 disabled:opacity-50"
                        >
                            Submit
                        </button>
                        <p class="mt-2 text-red-600">
                            {{ form.errors.answer ? 'Please select an option to proceed.' : '' }}
                        </p>
                    </div>
                </div>
            </div>
        </form>

        <div class="mt-12 rounded-md bg-pink-50 p-4" v-if="attempt.is_completed">
            <div class="flex">
                <div class="shrink-0">
                    <CheckCircleIcon class="size-5 text-pink-400" aria-hidden="true" />
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text-sm text-pink-700" v-if="attempt.is_correct">Yay! You answered it correctly!</p>
                    <p class="text-sm text-pink-700" v-else-if="attempt.is_timedout">Oops! The time ran out.</p>
                    <p class="text-sm text-pink-700" v-else>Oops! That's incorrect.</p>
                    <p class="mt-3 text-sm md:mt-0 md:ml-6">
                        <Link :href="route('qotd.stats')" class="font-medium whitespace-nowrap text-pink-700 hover:text-pink-600">
                            See your stats
                            <span aria-hidden="true"> &rarr;</span>
                        </Link>
                    </p>
                </div>
            </div>
        </div>
    </Qotd>
</template>
