<script setup>
import Narrow from '@/layouts/Narrow.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    totems: {
        type: Object,
        default: () => [],
    },
});

const form = useForm({
    totems: props.totems.map((totem) => ({
        id: totem.id,
        progress: [],
    })),
});

// everytime a checkbox is clicked, update the form data by pushing the page number into the progress array
function togglePage(totemId, pageNumber) {
    console.log('Toggling page', totemId, pageNumber);
}
</script>

<template>
    <Narrow>
        {{ totems }}
        <hr />

        {{ form }}
        <hr />

        <ul role="list" class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2">
            <li
                v-for="totem in totems"
                :key="totem.name"
                class="col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center shadow-sm"
            >
                <div class="p-6 pb-0">
                    <div class="flex flex-1 flex-col p-8">
                        <img
                            class="mx-auto size-32 shrink-0 rounded-full bg-gray-300 outline -outline-offset-1 outline-black/5"
                            src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60"
                            alt=""
                        />
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
                                        id="comments"
                                        aria-describedby="comments-description"
                                        name="comments"
                                        type="checkbox"
                                        @change="togglePage(totem.id, page)"
                                        class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
                                    />
                                    <svg
                                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
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
                                <label for="comments" class="font-medium text-gray-900">Pg. {{ page }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </Narrow>
</template>
