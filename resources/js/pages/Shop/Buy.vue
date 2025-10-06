<script setup lang="ts">
import QuantitySelector from '@/components/QuantitySelector.vue';
import VariantSelector from '@/components/VariantSelector.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

var props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

var form = useForm({
    variant: '',
    quantity: 1,
});

var options = ref([]);
onMounted(() => {
    options.value = props.product.variants.map((variant) => {
        return { value: variant.id, label: variant.title };
    });

    form.variant = options.value[0].value;
});

var checkout = () => {
    form.post(route('shop.checkout'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Buy"> </Head>

    <header class="absolute inset-x-0 top-0 z-50">
        <img src="/images/what-the-what-logo.svg" alt="What The What?! Logo" class="mx-auto mt-6 h-16 w-auto sm:h-18" />
    </header>

    <div class="m-32 mx-auto w-1/2">
        <form @submit.prevent="checkout">
            Buy What The What?!

            <div v-html="props.product.description_html" class="mb-4"></div>

            <VariantSelector :options="options" v-model="form.variant" />
            <QuantitySelector v-model="form.quantity" />

            <button
                type="submit"
                class="mt-4 rounded-md bg-violet-700 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
            >
                Checkout
            </button>

            {{ form.errors }}
        </form>
    </div>
</template>
