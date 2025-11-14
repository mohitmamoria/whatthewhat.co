<script setup>
import { BookOpenIcon } from '@heroicons/vue/16/solid';
import { BookmarkIcon } from '@heroicons/vue/20/solid';
import { InfiniteScroll } from '@inertiajs/vue3';

const props = defineProps({
    readings: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div class="mt-16 flow-root">
        <ul role="list" class="-mb-8">
            <InfiniteScroll data="readings">
                <li v-for="(reading, index) in readings.data" :key="reading.id">
                    <div class="relative pb-8">
                        <span
                            v-if="index !== readings.data.length - 1"
                            class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200"
                            aria-hidden="true"
                        ></span>
                        <div class="relative flex items-start space-x-3">
                            <div class="relative">
                                <img
                                    v-if="reading.book.cover_image_url"
                                    class="flex size-10 items-center justify-center rounded-full bg-gray-400 ring-8 ring-white outline -outline-offset-1 outline-black/5"
                                    :src="reading.book.cover_image_url"
                                    :alt="reading.book.title"
                                />
                                <div
                                    v-else
                                    class="flex size-10 items-center justify-center rounded-full bg-gray-100 ring-8 ring-white outline -outline-offset-1 outline-black/5"
                                >
                                    <BookOpenIcon class="size-8 text-pink-400" aria-hidden="true"></BookOpenIcon>
                                </div>

                                <span class="absolute -right-1 -bottom-0.5 rounded-tl bg-white px-0.5 py-px">
                                    <BookmarkIcon class="size-3 text-gray-400" aria-hidden="true" />
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <div class="flex items-center justify-between text-sm">
                                        <p class="font-medium text-gray-900">What The What?!</p>
                                        <time :datetime="reading.created_at" class="flex-none py-0.5 text-xs/5 text-gray-500">{{
                                            reading.created_at
                                        }}</time>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500">{{ reading.pages_read }} pages</p>
                                </div>
                                <div class="mt-2 text-sm text-gray-700">
                                    <p>{{ reading.notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </InfiniteScroll>
        </ul>
    </div>
</template>
