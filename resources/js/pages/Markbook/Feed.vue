<script setup>
import Markbook from '@/layouts/Markbook.vue';
import ReadingFeed from '@/partials/Markbook/ReadingFeed.vue';
import ReadingForm from '@/partials/Markbook/ReadingForm.vue';
import ReadingStats from '@/partials/Markbook/ReadingStats.vue';

const props = defineProps({
    stats: {
        type: Object,
        required: true,
    },
    readings: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Markbook>
        <ReadingForm />

        <ReadingStats :stats="stats" />

        <ReadingFeed :readings="readings" />
    </Markbook>
</template>
