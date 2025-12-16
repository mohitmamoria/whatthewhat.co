<script setup>
import Qotd from '@/layouts/Qotd.vue';
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/20/solid';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, onMounted, onUnmounted, ref } from 'vue';

const props = defineProps({
    attempt: {
        type: Object,
        required: true,
    },
});

const loggedInPlayer = usePage().props.auth.player;

const TIME_PER_QUESTION = props.attempt.time_left;

const form = useForm({
    answer: props.attempt.answer,
    time_left: TIME_PER_QUESTION,
});

const showOptions = ref(false);
let timer = null;

const timeout = () => {
    form.post(route('qotd.timeout', { attempt: props.attempt.name }));
};

const startTimer = () => {
    timer = setInterval(() => {
        if (form.time_left > 0) {
            form.time_left -= 1;
        } else {
            clearInterval(timer);
            timeout();
        }
    }, 1000);
};

const onOptionsRevealed = () => {
    if (!props.attempt.is_completed) {
        startTimer();
    }
};

onMounted(() => {
    if (props.attempt.is_completed) {
        showOptions.value = true;
        form.time_left = 0;
    } else {
        setTimeout(() => {
            showOptions.value = true;
        }, 2000);
    }
});

onUnmounted(() => {
    if (timer) {
        clearInterval(timer);
    }
});

const barLength = computed(() => {
    return 100 - ((TIME_PER_QUESTION - form.time_left) / TIME_PER_QUESTION) * 100;
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
        <div :class="attempt.is_completed ? 'invisible' : ''">
            <div class="mb-4 text-center">
                <span class="rounded-full bg-pink-600 p-2 px-4 text-xl font-bold text-white">{{
                    form.time_left > 0 ? form.time_left : 'TIMES UP!'
                }}</span>
            </div>
            <div class="my-2 overflow-hidden rounded-full bg-gray-200">
                <div class="h-2 rounded-full bg-pink-600 transition-[width] duration-300 ease-in-out" :style="{ width: barLength + '%' }"></div>
            </div>
        </div>

        <form class="space-y-2" @submit.prevent="submit">
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="px-4 py-5 sm:p-6">
                    <span
                        class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 inset-ring inset-ring-gray-500/10"
                        >Question</span
                    >
                    <article class="prose prose-xl mb-8 whitespace-pre-wrap" v-html="attempt.question.body_html"></article>

                    <!-- Options -->
                    <Transition
                        enter-active-class="transition-all duration-300 ease-out"
                        enter-from-class="opacity-0 translate-y-4"
                        enter-to-class="opacity-100 translate-y-0"
                        @after-enter="onOptionsRevealed"
                    >
                        <div v-if="showOptions" class="grid grid-cols-1 gap-3">
                            <label
                                v-for="(option, index) in attempt.question.options"
                                :key="index"
                                :aria-label="option"
                                class="group relative flex items-center justify-center rounded-md border border-gray-300 bg-white p-3 has-checked:border-gray-300 has-checked:bg-gray-300 has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-gray-300 has-disabled:border-gray-400 has-disabled:opacity-60"
                                :class="
                                    attempt.is_completed && attempt.correct_answer_index === index
                                        ? 'border-green-600! bg-green-100! has-checked:border-green-600! has-checked:bg-green-100!'
                                        : ''
                                "
                            >
                                <input
                                    type="radio"
                                    name="option"
                                    v-model="form.answer"
                                    :value="index"
                                    :disabled="attempt.is_completed"
                                    class="absolute inset-0 appearance-none focus:outline-none disabled:cursor-not-allowed"
                                />
                                <div class="flex w-full items-center">
                                    <div class="shrink-0" v-if="attempt.is_completed">
                                        <CheckCircleIcon
                                            class="size-5 text-green-600"
                                            aria-hidden="true"
                                            v-if="attempt.correct_answer_index === index"
                                        />
                                        <XCircleIcon v-else class="size-5 text-red-600" aria-hidden="true" />
                                    </div>
                                    <p class="block flex-1 text-center text-sm font-medium text-gray-900">{{ option }}</p>
                                </div>
                            </label>
                        </div>
                    </Transition>

                    <!-- Skeleton placeholder while waiting for options -->
                    <div v-if="!showOptions" class="grid grid-cols-1 gap-3">
                        <div v-for="n in attempt.question.options?.length || 4" :key="n" class="h-12 animate-pulse rounded-md bg-gray-200"></div>
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

        <div class="mt-12 mb-12 rounded-md bg-gray-800 p-4" v-if="attempt.is_completed">
            <div class="flex">
                <div class="shrink-0">
                    <CheckCircleIcon class="size-5 text-gray-400" aria-hidden="true" />
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text-sm text-gray-100" v-if="attempt.is_correct">Yay! You answered it correctly!</p>
                    <p class="text-sm text-gray-100" v-else-if="attempt.is_timedout">Oops! The time ran out.</p>
                    <p class="text-sm text-gray-100" v-else>Oops! That's incorrect.</p>
                    <p class="mt-3 text-sm md:mt-0 md:ml-6">
                        <Link :href="route('qotd.stats')" class="font-medium whitespace-nowrap text-gray-100 hover:text-white">
                            See your stats
                            <span aria-hidden="true"> &rarr;</span>
                        </Link>
                    </p>
                </div>
            </div>
        </div>
    </Qotd>
</template>
