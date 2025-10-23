<script setup>
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    variant: {
        type: Object,
        required: true,
    },
    quantity: {
        type: Number,
        default: 5,
    },
});

const options = [5, 10, 20, 50, 100, 500];

const form = useForm({
    ref: usePage().props.ref,
    variant: props.variant.id,
    quantity: props.quantity,
});

const checkout = () => {
    form.post(route('shop.checkout'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <form @submit.prevent="checkout" class="flex flex-col justify-between">
        <fieldset aria-label="How many books do you want to gift?">
            <div class="flex items-center justify-between">
                <div class="text-sm/6 font-medium text-gray-900">How many books do you want to gift?</div>
            </div>
            <div class="mt-2 grid grid-cols-3 gap-3 sm:grid-cols-6">
                <label
                    v-for="option in options"
                    :key="option"
                    :aria-label="option + ' books'"
                    class="group relative flex items-center justify-center rounded-md border border-gray-300 bg-white p-3 has-checked:border-gray-900 has-checked:bg-gray-900 has-focus-visible:outline-2 has-focus-visible:outline-offset-2 has-focus-visible:outline-gray-900 has-disabled:border-gray-400 has-disabled:bg-gray-200 has-disabled:opacity-25"
                >
                    <input
                        type="radio"
                        name="option"
                        :value="option"
                        v-model="form.quantity"
                        class="absolute inset-0 appearance-none focus:outline-none disabled:cursor-not-allowed"
                    />
                    <span class="text-sm font-medium text-gray-900 uppercase group-has-checked:text-white">{{ option }}</span>
                </label>
            </div>
        </fieldset>

        <button
            type="submit"
            class="mt-4 rounded-md bg-pink-600 px-2.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-pink-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600"
            :disabled="form.processing"
        >
            Buy {{ form.quantity }} for ₹{{ form.quantity * variant.price }} &rarr;
        </button>
    </form>
</template>
