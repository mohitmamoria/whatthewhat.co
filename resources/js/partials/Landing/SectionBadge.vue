<script setup lang="ts">
defineProps({
    color: {
        type: String,
        default: 'bg-sun',
    },
    rotation: {
        type: String,
        default: '-rotate-2',
    },
});
</script>

<template>
    <span
        :class="[color, rotation]"
        class="inline-block rounded-full border-2 border-ink px-3 py-1 text-[0.7rem] font-bold tracking-wide uppercase shadow-stickersm"
    >
        <slot />
    </span>
</template>
