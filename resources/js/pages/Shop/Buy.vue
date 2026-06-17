<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Nav from '@/partials/Landing/Nav.vue';
import Hero from '@/partials/Landing/Hero.vue';
import Quote from '@/partials/Landing/Quote.vue';
import About from '@/partials/Landing/About.vue';
import Sample from '@/partials/Landing/Sample.vue';
import TreasureHunt from '@/partials/Landing/TreasureHunt.vue';
import SignedCopy from '@/partials/Landing/SignedCopy.vue';
import Order from '@/partials/Landing/Order.vue';
import Ticker from '@/partials/Landing/Ticker.vue';
import Authors from '@/partials/Landing/Authors.vue';
import Faq from '@/partials/Landing/Faq.vue';
import Footer from '@/partials/Landing/Footer.vue';

defineProps({
    product: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head title="A Field Guide to Curious Things">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Space+Mono:wght@400;700&display=swap"
            rel="stylesheet"
        />
    </Head>

    <div class="wtw-landing min-h-screen font-space-mono text-ink antialiased selection:bg-ink selection:text-lime">
        <Nav />
        <main id="top">
            <Hero />
            <Quote color="bg-grape" rotation="-rotate-1" author="Aarav Mehta · Reader, Mumbai">
                “I picked it up to read one page and looked up an hour later. It ruins small talk forever — in the best way.”
            </Quote>
            <About />
            <Quote color="bg-sun" rotation="rotate-1" author="Priya Nair · Reader, Bengaluru">
                “Equal parts clever and ridiculous. I've quoted it at three dinners and counting.”
            </Quote>
            <Sample />
            <TreasureHunt />
            <SignedCopy />
            <Order :variants="product.variants" />
            <Ticker />
            <Authors />
            <Faq />
        </main>
        <Footer />
    </div>
</template>

<style scoped>
.wtw-landing {
    background-color: var(--color-paper);
    background-image:
        linear-gradient(to right, rgba(28, 26, 23, 0.05) 1px, transparent 1px),
        linear-gradient(to bottom, rgba(28, 26, 23, 0.05) 1px, transparent 1px);
    background-size: 26px 26px;
}
</style>
