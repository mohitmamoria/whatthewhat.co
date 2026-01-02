<script setup>
import Narrow from '@/layouts/Narrow.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    totems: {
        type: Object,
        default: () => [],
    },
});

const forms = {};
props.totems.forEach((totem) => {
    forms[totem.id] = useForm({
        // have a key in the form for each page in the totem's pages array, set to false initially
        pages: totem.pages.reduce((acc, page) => {
            acc[page] = totem.progress.includes(page) ? true : false;
            return acc;
        }, {}),
    });
});

// everytime a checkbox is clicked, update the form data by pushing the page number into the progress array
function updateProgress(totemId, page) {
    forms[totemId].put(route('totems.update-progress', { totem: totemId, page: page }), {
        preserveScroll: true,
    });
}
</script>

<template>
    <Narrow>
        <div class="text-center">
            <p class="mt-2 font-serif text-2xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-3xl">Totems</p>
            <p class="mt-6 text-lg/8 text-gray-700">Collect them as you read the book. Can you collect them all?</p>
        </div>

        <ul role="list" class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2">
            <li
                v-for="totem in totems"
                :key="totem.name"
                class="col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center shadow-sm"
            >
                <div class="p-6 pb-0">
                    <div class="flex flex-1 flex-col p-8">
                        <img class="mx-auto size-32 shrink-0" src="/images/totems/badge.png" alt="Totem Badge" />
                        <dd class="mt-3">
                            <span
                                v-if="totem.is_collected"
                                class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 inset-ring inset-ring-green-600/20"
                                >Collected</span
                            >
                            <span
                                v-else
                                class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 inset-ring inset-ring-red-600/20"
                                >Not Yet Collected</span
                            >
                        </dd>
                        <h3 class="mt-6 text-xl font-bold text-gray-900">{{ totem.name }}</h3>
                        <dl class="flex grow flex-col justify-between">
                            <dt class="sr-only">Description</dt>
                            <dd class="text-md font-serif text-gray-500">{{ totem.description }}</dd>
                            <dt class="sr-only">Is collected?</dt>
                        </dl>
                    </div>

                    <div class="mb-4 flex flex-row justify-between">
                        <div v-for="page in totem.pages" :key="`totem-${totem.id}-page-${page}`" class="flex gap-1">
                            <div class="flex h-6 shrink-0 items-center">
                                <div class="group grid size-4 grid-cols-1">
                                    <input
                                        :id="`totem-${totem.id}-page-${page}`"
                                        aria-describedby="comments-description"
                                        name="comments"
                                        type="checkbox"
                                        v-model="forms[totem.id].pages[page]"
                                        @change="updateProgress(totem.id, page)"
                                        :disabled="forms[totem.id].pages[page]"
                                        class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 forced-colors:appearance-auto"
                                    />
                                    <svg
                                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white"
                                        viewBox="0 0 14 14"
                                        fill="none"
                                    >
                                        <path
                                            class="opacity-0 group-has-checked:opacity-100"
                                            d="M3 8L6 11L11 3.5"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                        <path
                                            class="opacity-0 group-has-indeterminate:opacity-100"
                                            d="M3 7H11"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-sm/6">
                                <label :for="`totem-${totem.id}-page-${page}`" class="font-medium text-gray-900">Pg. {{ page }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </Narrow>
</template>
