<script setup>
import VariantCheckout from '@/components/VariantCheckout.vue';
import BonusPages from '@/partials/BonusPages.vue';

const props = defineProps({
    variants: {
        type: Array,
        default: () => [],
    },
});

const badges = {
    // 'wtw-book-solo': {
    //     label: '🎉 Best Value',
    //     color: 'bg-green-50 text-green-700 ',
    // },
    'wtw-book-calendar': {
        label: '🎉 Best Value',
        color: 'bg-green-50 text-green-700 ',
    },
    // 'wtw-book-calendar-duo': {
    //     label: '🎉 Best Value',
    //     color: 'bg-green-50 text-green-700 ',
    // },
};

const cutoutPrice = {
    'wtw-book-solo': 399,
    'wtw-book-calendar': 899,
    'wtw-book-calendar-duo': 1798,
};
</script>

<template>
    <div class="mt-12 bg-white py-12">
        <div class="mx-auto max-w-7xl lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-sm font-semibold text-indigo-600">Exclusive author signed copies</h2>
                <p class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl lg:text-balance">
                    Get your signed copy now
                </p>
                <p class="mt-6 text-lg/8 text-balance text-gray-600">Price that fits every pocket, including students!</p>
            </div>

            <div class="relative isolate mt-4 overflow-hidden bg-white">
                <div class="px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <div class="py-6">
                            <p
                                class="mx-auto mt-6 max-w-xl font-serif text-4xl font-bold text-pretty text-gray-900 line-through decoration-red-500 sm:text-5xl"
                            >
                                ₹1399
                            </p>
                            <p
                                class="mx-auto mt-6 max-w-xl font-serif text-3xl font-bold text-pretty text-gray-900 line-through decoration-red-500 sm:text-4xl"
                            >
                                ₹999
                            </p>
                            <p
                                class="mx-auto mt-6 max-w-xl font-serif text-2xl font-bold text-pretty text-gray-900 line-through decoration-red-500 sm:text-3xl"
                            >
                                ₹599
                            </p>
                            <p
                                class="mx-auto mt-6 max-w-xl font-serif text-2xl font-bold text-pretty text-gray-900 line-through decoration-red-500 sm:text-3xl"
                            >
                                ₹399
                            </p>
                            <div class="-rotate-6">
                                <p class="mx-auto mt-6 max-w-xl font-serif text-6xl font-bold text-pretty text-gray-900 sm:text-8xl">₹299</p>
                                <p class="mx-auto mt-2 max-w-xl font-serif text-2xl font-bold text-pretty text-gray-900">ONLY</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <BonusPages />

            <div class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <ul role="list" class="divide-y divide-gray-200 xl:col-span-3">
                        <template v-for="(variant, index) in variants" :key="variant.id">
                            <li v-if="!variant.sku.endsWith('duo')" class="flex flex-col gap-10 py-12 first:pt-0 last:pb-0 sm:flex-row">
                                <!-- <img
                                    class="hidden w-full flex-none rounded object-cover outline-1 -outline-offset-1 outline-black/5 sm:inline-block sm:w-32"
                                    :src="'/images/' + variant.sku + '-desktop.jpg'"
                                    :alt="variant.title"
                                />
                                <img
                                    class="w-full flex-none rounded object-cover outline-1 -outline-offset-1 outline-black/5 sm:hidden sm:w-32"
                                    :src="'/images/' + variant.sku + '-mobile.jpg'"
                                    :alt="variant.title"
                                /> -->

                                <img
                                    class="w-full flex-none rounded object-cover outline-1 -outline-offset-1 outline-black/5 sm:w-32"
                                    :src="variant.image_src"
                                    :alt="variant.title"
                                />
                                <div class="max-w-xl flex-auto">
                                    <span
                                        v-if="badges[variant.sku]"
                                        class="inline-flex items-center rounded-full px-1.5 py-0.5 text-xs font-medium inset-ring inset-ring-purple-700/10"
                                        :class="badges[variant.sku].color"
                                        >{{ badges[variant.sku].label }}</span
                                    >
                                    <h3 class="text-lg/8 font-semibold tracking-tight text-gray-900">For {{ variant.title }}</h3>
                                    <p class="font-xs font-bold text-gray-700">
                                        <span class="font-normal line-through decoration-gray-500" v-if="cutoutPrice[variant.sku]"
                                            >₹{{ cutoutPrice[variant.sku] }}</span
                                        >
                                        ₹{{ variant.price }} only
                                    </p>
                                    <article class="prose prose-sm mt-2" v-html="variant.description"></article>
                                    <VariantCheckout :variant="variant"></VariantCheckout>
                                </div>
                            </li>
                        </template>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>
