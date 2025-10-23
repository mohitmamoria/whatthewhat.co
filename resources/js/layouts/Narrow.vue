<script setup>
import Footer from '@/partials/Footer.vue';
import PlayerTopBar from '@/partials/PlayerTopBar.vue';
</script>

<template>
    <div>
        <div class="relative isolate mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- We've used 3xl here, but feel free to try other max-widths based on your needs -->
            <div class="mx-auto max-w-xl">
                <PlayerTopBar></PlayerTopBar>

                <header class="mb-12">
                    <img src="/images/what-the-what-logo.svg" alt="What The What?! Logo" class="mx-auto mt-6 h-16 w-auto sm:h-18" />
                </header>
                <!-- Content goes here -->
                <slot></slot>
            </div>
        </div>
    </div>
    <Footer class="mt-64" />
</template>
