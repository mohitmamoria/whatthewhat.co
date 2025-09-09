<script setup lang="ts">
import Features from '@/partials/Features.vue';
import Hero from '@/partials/Hero.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Averia+Serif+Libre:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Boogaloo&display=swap"
            rel="stylesheet"
        />
    </Head>
    <Hero />
    <Features />
</template>
