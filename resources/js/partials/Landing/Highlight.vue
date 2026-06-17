<script setup lang="ts">
defineProps({
    color: {
        type: String,
        default: '#c8f169',
    },
});
</script>

<template>
    <span class="px-[0.1em]" :style="{ background: `linear-gradient(180deg, transparent 55%, ${color} 55%)` }"><slot /></span>
</template>
