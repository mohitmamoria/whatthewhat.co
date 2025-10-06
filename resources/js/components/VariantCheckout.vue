<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import QuantitySelector from './QuantitySelector.vue';

const props = defineProps({
    variant: {
        type: String,
        required: true,
    },
    quantity: {
        type: Number,
        default: 1,
    },
});

var form = useForm({
    ref: usePage().props.ref,
    variant: props.variant,
    quantity: props.quantity,
});

var checkout = () => {
    form.post(route('shop.checkout'), {
        preserveScroll: true,
    });
};
</script>

<template>
    {{}}
    <form @submit.prevent="checkout" class="text-center">
        <QuantitySelector class="mx-auto" v-model="form.quantity" />
        <button
            type="submit"
            class="mt-4 rounded-md bg-violet-700 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
        >
            Checkout
        </button>
    </form>
</template>
