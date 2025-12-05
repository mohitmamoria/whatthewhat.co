<script setup>
import Qotd from '@/layouts/Qotd.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    question: {
        type: Object,
        required: true,
    },
});

const loggedInPlayer = usePage().props.auth.player;

const form = useForm({
    answer: null,
});

const submit = () => {
    form.post(route('qotd.attempt'));
};
</script>

<template>
    <Qotd>
        {{ question }} {{ form }}

        <div>
            <article class="pros mb-8 whitespace-pre-wrap" v-html="question.body_html"></article>

            <form class="space-y-2" @submit.prevent="submit">
                <div class="mt-2 grid grid-cols-1 gap-3">
                    <label
                        v-for="(option, index) in question.options"
                        :key="index"
                        :aria-label="option"
                        class="group relative flex items-center justify-center rounded-md border border-gray-300 bg-white p-3 has-checked:border-gray-300 has-checked:bg-gray-300 has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-gray-300 has-disabled:border-gray-400 has-disabled:bg-gray-200 has-disabled:opacity-25"
                    >
                        <input
                            type="radio"
                            name="option"
                            v-model="form.answer"
                            :value="index"
                            class="absolute inset-0 appearance-none focus:outline-none disabled:cursor-not-allowed"
                        />
                        <span class="text-sm font-medium text-gray-900">{{ option }}</span>
                    </label>
                </div>

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
            </form>
        </div>
    </Qotd>
</template>
