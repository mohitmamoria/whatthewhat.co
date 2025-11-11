<script setup>
import Combobox from '@/components/Combobox.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    books: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    book: null,
    pages_read: 1,
    notes: '',
});

const submit = () => {
    form.transform((data) => ({
        book_id: data.book.id,
        pages_read: data.pages_read,
        notes: data.notes,
    })).post(route('markbook.readings.store'), {
        onSuccess: () => {
            form.reset('pages_read', 'notes');
        },
    });
};

const searchBooks = async (query) => {
    if (query.length < 3) {
        return [];
    }

    const response = await fetch(route('markbook.book-search', { q: query }));
    if (!response.ok) {
        console.error('Failed to fetch books');
        return [];
    }

    return await response.json();
};
</script>

<template>
    <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow-sm">
        <div class="px-4 py-5 sm:px-6">What did you read today?</div>
        <div class="px-4 py-5 sm:p-6">
            <form @submit.prevent="submit" class="mx-auto max-w-xl">
                <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-8">
                    <div class="sm:col-span-6">
                        <Combobox v-model="form.book" label="Book" :search="searchBooks" />
                    </div>
                    <div class="sm:col-span-2">
                        <label for="pages" class="block text-sm/6 font-semibold text-gray-900">Pages</label>
                        <div class="mt-2.5">
                            <input
                                type="number"
                                name="pages_read"
                                id="pages"
                                v-model="form.pages_read"
                                min="1"
                                class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"
                            />
                        </div>
                    </div>
                    <div class="sm:col-span-8">
                        <label for="notes" class="block text-sm/6 font-semibold text-gray-900">Notes</label>
                        <div class="mt-2.5">
                            <textarea
                                rows="4"
                                name="notes"
                                id="notes"
                                v-model="form.notes"
                                class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            ></textarea>
                        </div>
                    </div>
                    <div class="sm:col-span-8">
                        <button
                            type="submit"
                            class="flex w-full justify-center rounded-md bg-pink-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-pink-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600"
                        >
                            Record Reading
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
