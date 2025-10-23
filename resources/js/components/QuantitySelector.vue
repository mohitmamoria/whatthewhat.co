<script setup>
import { MinusIcon, PlusIcon } from '@heroicons/vue/16/solid';
import { defineEmits, ref } from 'vue';

const props = defineProps({
    modelValue: {
        type: Number,
        required: true,
    },
});
const emit = defineEmits(['update:modelValue']);

const quantity = ref(props.modelValue);

const increment = () => {
    if (quantity.value < 10) {
        quantity.value++;
        emit('update:modelValue', parseInt(quantity.value));
    }
};

const decrement = () => {
    if (quantity.value > 1) {
        quantity.value--;
        emit('update:modelValue', parseInt(quantity.value));
    }
};
</script>

<template>
    <div class="w-32">
        <!-- <label for="quantity" class="block text-sm/6 font-medium text-gray-900">Quantity</label> -->
        <div class="mt-2 flex">
            <button
                type="button"
                class="flex shrink-0 items-center gap-x-1.5 rounded-l-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 outline-1 -outline-offset-1 outline-gray-300 hover:bg-gray-50 focus:relative focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                @click="decrement"
            >
                <MinusIcon class="-ml-0.5 size-4" aria-hidden="true" />
            </button>
            <div class="-mx-px grid grow grid-cols-1 focus-within:relative">
                <input
                    type="number"
                    min="1"
                    max="10"
                    name="quantity"
                    id="quantity"
                    class="col-start-1 row-start-1 block w-full bg-white py-1.5 text-center text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    placeholder="1"
                    :value="props.modelValue"
                    disabled
                />
            </div>
            <button
                type="button"
                class="flex shrink-0 items-center gap-x-1.5 rounded-r-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 outline-1 -outline-offset-1 outline-gray-300 hover:bg-gray-50 focus:relative focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                @click="increment"
            >
                <PlusIcon class="-ml-0.5 size-4" aria-hidden="true" />
            </button>
        </div>
    </div>
</template>

<style scoped>
input[type='number']::-webkit-inner-spin-button,
input[type='number']::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
button {
    touch-action: manipulation;
}
</style>
