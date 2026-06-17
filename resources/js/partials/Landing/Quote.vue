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
});
</script>

<template>
    <section class="mx-auto max-w-3xl px-5 py-14">
        <figure :class="[color, rotation]" class="rounded-3xl border-2 border-ink p-8 text-center shadow-pop md:p-10">
            <blockquote class="font-fraunces text-2xl font-medium italic leading-snug md:text-3xl">
                <slot />
            </blockquote>
            <figcaption class="mt-5 text-xs font-bold tracking-wide uppercase">{{ author }}</figcaption>
        </figure>
    </section>
</template>
