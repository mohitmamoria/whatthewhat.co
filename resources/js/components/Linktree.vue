<script setup>
import { ChevronRightIcon } from '@heroicons/vue/20/solid';
import { defineProps } from 'vue';

const props = defineProps({
    links: {
        type: Array,
        default: () => [],
    },
});

</script>

<template>
    <ul role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-xs outline-1 outline-gray-900/5 sm:rounded-xl">
        <li v-for="(link, index) in links" :key="index" class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
            <div class="flex min-w-0 gap-x-4">
                <img class="size-12 flex-none rounded-full bg-gray-50" :src="link.imageUrl" alt="" />
                <div class="min-w-0 flex-auto">
                    <p class="text-sm/6 font-semibold text-gray-900">
                        <a :href="link.href" target="_blank">
                            <span class="absolute inset-x-0 -top-px bottom-0"></span>
                            {{ link.name }}
                        </a>
                    </p>
                    <p class="mt-1 flex text-xs/5 text-gray-500">
                        <p>{{ link.platform }}</p>
                    </p>
                </div>
            </div>
            <div class="flex shrink-0 items-center gap-x-4">
                <div class="hidden sm:flex sm:flex-col sm:items-end">
                    <p class="text-xs/5 text-gray-500">{{link.label}}</p>
                </div>
                <ChevronRightIcon class="size-5 flex-none text-gray-400" aria-hidden="true" />
            </div>
        </li>
    </ul>
</template>
