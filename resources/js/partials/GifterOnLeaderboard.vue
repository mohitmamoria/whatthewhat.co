<script setup>
import Crown from '@/components/Crown.vue';

const props = defineProps({
    gift: {
        type: Object,
        required: true,
    },
    rank: {
        type: Number,
        required: true,
    },
});
</script>

<template>
    <div class="flex items-center justify-between gap-x-6 gap-y-4 py-5">
        <div class="flex flex-shrink-0 items-center space-x-4">
            <div class="flex h-12 w-12 items-center justify-center overflow-clip rounded-full bg-[#170C29]">
                <Crown :position="rank"></Crown>
            </div>
            <p class="text-sm leading-6 font-semibold text-gray-900">
                {{ gift.gifter_name }}
            </p>
        </div>
        <div class="flex items-center gap-x-2.5">
            <p>
                <span class="sr-only">Total gifts given</span>
            </p>
            <p class="text-sm leading-6 text-gray-900">🎁 &times; {{ gift.total_count }}</p>
        </div>
    </div>
</template>
