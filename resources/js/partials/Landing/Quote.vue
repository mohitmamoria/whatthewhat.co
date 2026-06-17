<script setup lang="ts">
defineProps({
    color: {
        type: String,
        default: 'bg-grape',
    },
    rotation: {
        type: String,
        default: '-rotate-1',
    },
    author: {
        type: String,
        required: true,
    },
    avatar: {
        type: String,
        default: null,
    },
});
</script>

<template>
    <section class="mx-auto max-w-3xl px-5 py-14">
        <figure :class="[color, rotation]" class="relative rounded-3xl border-2 border-ink p-8 pt-16 text-center shadow-pop md:p-10 md:pt-20">
            <img
                v-if="avatar"
                :src="avatar"
                :alt="author"
                class="absolute -top-12 left-1/2 h-24 w-24 -translate-x-1/2 rotate-3 rounded-full border-4 border-ink bg-cream object-cover drop-shadow-lg md:-top-16 md:h-32 md:w-32"
            />
            <blockquote class="font-fraunces text-2xl leading-snug font-medium italic md:text-3xl">
                <slot />
            </blockquote>
            <figcaption class="mt-5 text-xs font-bold tracking-wide uppercase">{{ author }}</figcaption>
        </figure>
    </section>
</template>
