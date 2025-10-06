<script setup>
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Buy"></Head>

    <header class="absolute inset-x-0 top-0 z-50">
        <img src="/images/what-the-what-logo.svg" alt="What The What?! Logo" class="mx-auto mt-6 h-16 w-auto sm:h-18" />
    </header>

    <div class="mx-auto mt-48 max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
        <div class="mx-auto max-w-3xl">
            <!-- Content goes here -->
            <slot></slot>
        </div>
    </div>
</template>
