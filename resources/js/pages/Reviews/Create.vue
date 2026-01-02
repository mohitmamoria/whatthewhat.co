<script setup>
import PageHeading from '@/components/PageHeading.vue';
import Narrow from '@/layouts/Narrow.vue';
import { StarIcon } from '@heroicons/vue/20/solid';
import { Link, useForm, usePage } from '@inertiajs/vue3';

const props = defineProps({
    review: {
        type: Object,
        default: null,
    },
});

const loggedInPlayer = usePage().props.auth.player;

const form = useForm({
    rating: props.review.rating || 5,
    title: props.review.title || '',
    body: props.review.body || '',
});

const submit = () => {
    form.post(route('reviews.store'), {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>

<template>
    <Narrow>
        <PageHeading>
            Leave a Review
            <template #description> If you enjoyed the book, please let the world know.</template>
        </PageHeading>

        <div v-if="!loggedInPlayer" class="mt-10 flex items-center justify-center gap-x-6">
            <Link
                :href="route('auth.player.login', { next: route('reviews.create') })"
                class="rounded-md bg-gray-700 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-gray-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800"
                >Please login using WhatsApp to review &rarr;</Link
            >
        </div>
        <div v-else>
            <form @submit.prevent="submit">
                <div class="space-y-12">
                    <div class="border-b border-gray-900/10 pb-12">
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-full">
                                <div class="flex items-center gap-1">
                                    <label v-for="rating in [1, 2, 3, 4, 5]" :key="rating" class="cursor-pointer">
                                        <input
                                            :aria-label="rating + ' stars'"
                                            type="radio"
                                            name="rating"
                                            :value="rating"
                                            v-model="form.rating"
                                            class="sr-only"
                                        />
                                        <StarIcon
                                            :class="[
                                                form.rating >= rating ? 'text-yellow-400' : 'text-gray-200',
                                                'size-6 transition-colors hover:text-yellow-400',
                                            ]"
                                        />
                                    </label>
                                </div>
                            </div>

                            <div class="sm:col-span-full">
                                <label for="title" class="block text-sm/6 font-medium text-gray-900"
                                    >Title <span class="text-sm text-gray-400">(optional)</span></label
                                >
                                <div class="mt-2">
                                    <input
                                        type="text"
                                        name="title"
                                        id="title"
                                        v-model="form.title"
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-pink-600 sm:text-sm/6"
                                    />
                                </div>
                            </div>

                            <div class="col-span-full">
                                <label for="body" class="block text-sm/6 font-medium text-gray-900"
                                    >Review <span class="text-sm text-gray-400">(optional)</span></label
                                >
                                <p class="mt-1 text-sm/6 text-gray-600">Is there anything you would like to share about your experience?</p>
                                <div class="mt-2">
                                    <textarea
                                        name="body"
                                        id="body"
                                        rows="3"
                                        v-model="form.body"
                                        class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-pink-600 sm:text-sm/6"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button
                    type="submit"
                    class="mt-4 rounded-md bg-pink-600 px-2.5 py-2 text-sm font-semibold text-white shadow-xs hover:bg-pink-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-700 disabled:opacity-50"
                    :disabled="form.processing"
                >
                    Submit &rarr;
                </button>

                <p v-if="form.recentlySuccessful" class="mt-2 text-sm text-gray-600">Success! Thank you for your review.</p>
            </form>
        </div>
    </Narrow>
</template>
