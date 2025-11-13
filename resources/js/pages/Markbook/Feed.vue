<script setup>
import Markbook from '@/layouts/Markbook.vue';
import ReadingFeed from '@/partials/Markbook/ReadingFeed.vue';
import ReadingForm from '@/partials/Markbook/ReadingForm.vue';
</script>

<template>
    <Markbook>
        <ReadingForm />

        <ReadingFeed />
    </Markbook>
</template>
