<script setup>
import { Combobox, ComboboxButton, ComboboxInput, ComboboxLabel, ComboboxOption, ComboboxOptions } from '@headlessui/vue';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';
import { ref, watch } from 'vue';

const props = defineProps({
    label: {
        type: String,
        default: 'Select an option',
    },
    search: {
        type: Function,
        default: () => [],
    },
});

const query = ref('');
const selected = ref(null);
const filteredOptions = ref([]);
const isLoading = ref(false);

// Debounce timer
let debounceTimer = null;

// Watch query changes and call the search API
watch(query, async (newQuery) => {
    // Clear the previous timer
    if (debounceTimer) {
        clearTimeout(debounceTimer);
    }

    // If query is empty, clear results
    if (newQuery === '') {
        filteredOptions.value = [];
        return;
    }

    // Debounce the API call (300ms delay)
    debounceTimer = setTimeout(async () => {
        isLoading.value = true;
        try {
            const results = await props.search(newQuery);
            filteredOptions.value = results.data;
        } catch (error) {
            console.error('Search failed:', error);
            filteredOptions.value = [];
        } finally {
            isLoading.value = false;
        }
    }, 300);
});
</script>

<template>
    <Combobox as="div" v-model="selected" @update:modelValue="query = ''">
        <ComboboxLabel class="block text-sm/6 font-semibold text-gray-900">{{ label }}</ComboboxLabel>
        <div class="relative mt-2.5">
            <ComboboxInput
                class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                @change="query = $event.target.value"
                @blur="query = ''"
                :display-value="(book) => book?.title"
            />
            <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-hidden">
                <ChevronDownIcon class="size-5 text-gray-400" aria-hidden="true" />
            </ComboboxButton>

            <transition leave-active-class="transition ease-in duration-100" leave-from-class="" leave-to-class="opacity-0">
                <ComboboxOptions
                    v-if="filteredOptions.length > 0 || query.length > 0"
                    class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg outline outline-black/5 sm:text-sm"
                >
                    <li v-if="isLoading" class="relative cursor-default px-3 py-2 text-gray-900 select-none">
                        <span class="block truncate">Searching...</span>
                    </li>
                    <li v-if="filteredOptions.length === 0 && !isLoading" class="relative cursor-default px-3 py-2 text-gray-900 select-none">
                        <span class="block truncate">No results found</span>
                    </li>
                    <ComboboxOption v-for="option in filteredOptions" :key="option.id" :value="option" as="template" v-slot="{ active }">
                        <li
                            :class="[
                                'relative cursor-default px-3 py-2 select-none',
                                active ? 'bg-indigo-600 text-white outline-hidden' : 'text-gray-900',
                            ]"
                        >
                            <div class="flex">
                                <span class="truncate">
                                    {{ option.title }}
                                </span>
                                <span :class="['ml-2 truncate text-gray-500', active ? 'text-white' : 'text-gray-500']">
                                    {{ option.published_year }}
                                </span>
                            </div>
                        </li>
                    </ComboboxOption>
                </ComboboxOptions>
            </transition>
        </div>
    </Combobox>
</template>
