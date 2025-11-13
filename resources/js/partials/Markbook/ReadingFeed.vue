<script setup>
import { ChatBubbleLeftEllipsisIcon } from '@heroicons/vue/20/solid';

const activity = [
    {
        id: 1,
        type: 'comment',
        person: { name: 'Eduardo Benz', href: '#' },
        imageUrl:
            'https://images.unsplash.com/photo-1520785643438-5bf77931f493?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80',
        comment:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt nunc ipsum tempor purus vitae id. Morbi in vestibulum nec varius. Et diam cursus quis sed purus nam.',
        date: '6d ago',
    },
    {
        id: 4,
        type: 'comment',
        person: { name: 'Jason Meyers', href: '#' },
        imageUrl:
            'https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80',
        comment:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt nunc ipsum tempor purus vitae id. Morbi in vestibulum nec varius. Et diam cursus quis sed purus nam. Scelerisque amet elit non sit ut tincidunt condimentum. Nisl ultrices eu venenatis diam.',
        date: '2h ago',
    },
    {
        id: 7,
        type: 'comment',
        person: { name: 'Eduardo Benz', href: '#' },
        imageUrl:
            'https://images.unsplash.com/photo-1520785643438-5bf77931f493?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80',
        comment:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt nunc ipsum tempor purus vitae id. Morbi in vestibulum nec varius. Et diam cursus quis sed purus nam.',
        date: '6d ago',
    },
];
</script>

<template>
    <div class="mt-16 flow-root">
        <ul role="list" class="-mb-8">
            <li v-for="(activityItem, activityItemIdx) in activity" :key="activityItem.id">
                <div class="relative pb-8">
                    <span
                        v-if="activityItemIdx !== activity.length - 1"
                        class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200"
                        aria-hidden="true"
                    ></span>
                    <div class="relative flex items-start space-x-3">
                        <template v-if="activityItem.type === 'comment'">
                            <div class="relative">
                                <img
                                    class="flex size-10 items-center justify-center rounded-full bg-gray-400 ring-8 ring-white outline -outline-offset-1 outline-black/5"
                                    :src="activityItem.imageUrl"
                                    alt=""
                                />

                                <span class="absolute -right-1 -bottom-0.5 rounded-tl bg-white px-0.5 py-px">
                                    <ChatBubbleLeftEllipsisIcon class="size-5 text-gray-400" aria-hidden="true" />
                                </span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <div class="flex items-center justify-between text-sm">
                                        <a :href="activityItem.person.href" class="font-medium text-gray-900">What The What?!</a>
                                        <time :datetime="activityItem.dateTime" class="flex-none py-0.5 text-xs/5 text-gray-500">{{
                                            activityItem.date
                                        }}</time>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500">23 pages</p>
                                </div>
                                <div class="mt-2 text-sm text-gray-700">
                                    <p>{{ activityItem.comment }}</p>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>
