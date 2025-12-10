<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    question: {
        type: Object,
        required: true,
    },
});

const form = useForm({});
const attempt = () => {
    form.post(route('qotd.attempts', { question: props.question.name }));
};
</script>

<template>
    <div class="mx-auto gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none">
        <div class="text-center">
            <p class="mt-2 font-serif text-2xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-3xl">Question Of The Day</p>
            <p class="mt-6 text-lg/8 text-gray-700">One question. Thirteen seconds to answer. Are you ready?</p>
        </div>
        <div class="mt-12 text-center">
            <form @submit.prevent="attempt">
                <button
                    type="submit"
                    class="mt-4 rounded-md bg-pink-600 px-2.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-pink-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-700"
                    :disabled="form.processing"
                >
                    Play QOTD &rarr;
                </button>
            </form>
        </div>
    </div>
</template>
