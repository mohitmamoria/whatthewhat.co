<script setup>
import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid';
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
    <div v-if="!variant.is_available">
        <div class="mt-4 rounded-md bg-yellow-50 p-4">
            <div class="flex">
                <div class="shrink-0">
                    <ExclamationTriangleIcon class="size-5 text-yellow-400" aria-hidden="true" />
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-yellow-800">SOLD OUT!</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Sorry, this item is no longer available.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <form @submit.prevent="checkout" class="flex items-end justify-between">
            <QuantitySelector v-model="form.quantity" />

            <button
                type="submit"
                class="mt-4 rounded-md bg-pink-600 px-2.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-pink-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                :disabled="form.processing"
            >
                Buy {{ form.quantity }} for ₹{{ form.quantity * variant.price }} &rarr;
            </button>
        </form>
    </div>
</template>
