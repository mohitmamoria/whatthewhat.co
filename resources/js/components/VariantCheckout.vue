<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import QuantitySelector from './QuantitySelector.vue';

const props = defineProps({
    variant: {
        type: Object,
        required: true,
    },
    quantity: {
        type: Number,
        default: 1,
    },
});

var form = useForm({
    ref: usePage().props.ref,
    variant: props.variant.id,
    quantity: props.quantity,
});

var checkout = () => {
    form.post(route('shop.checkout'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <form @submit.prevent="checkout" class="flex items-end justify-between">
        <QuantitySelector v-model="form.quantity" />

        <button
            type="submit"
            class="mt-4 rounded-md bg-pink-600 px-2.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-pink-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        >
            Buy {{ form.quantity }} for ₹{{ form.quantity * variant.price }} &rarr;
        </button>
    </form>
</template>
