<script setup lang="ts">
import About from '@/partials/Landing/About.vue';
import Authors from '@/partials/Landing/Authors.vue';
import Faq from '@/partials/Landing/Faq.vue';
import Footer from '@/partials/Landing/Footer.vue';
import Hero from '@/partials/Landing/Hero.vue';
import Nav from '@/partials/Landing/Nav.vue';
import Order from '@/partials/Landing/Order.vue';
import Quote from '@/partials/Landing/Quote.vue';
import Sample from '@/partials/Landing/Sample.vue';
import SignedCopy from '@/partials/Landing/SignedCopy.vue';
import Ticker from '@/partials/Landing/Ticker.vue';
import TreasureHunt from '@/partials/Landing/TreasureHunt.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    product: {
        type: Object,
        required: true,
    },
    reviews: {
        type: Array,
        default: () => [],
    },
});

const quotes = [
    {
        id: 'vishy',
        color: 'bg-grape',
        rotation: '-rotate-1',
        author: 'Viswanathan Anand · 5-time World Chess Champion',
        avatar: '/images/landing/quote-vishy.jpg',
        text: 'A splendid job making knowledge both accessible and fun — now transitioned brilliantly from the screen to the page.',
    },
    {
        id: 'warikoo',
        color: 'bg-sun',
        rotation: 'rotate-1',
        author: 'Ankur Warikoo · Entrepreneur & Author',
        avatar: '/images/landing/quote-warikoo.jpg',
        text: "It won't cure your curiosity. It'll make it incurable.",
    },
    {
        id: 'mithila',
        color: 'bg-sky',
        rotation: '-rotate-1',
        author: 'Mithila Palkar · Actor',
        avatar: '/images/landing/quote-mithila.jpg',
        text: 'This book has the same magic, just printed — every ‘what?’ turns into a ‘WHAT!’',
    },
    {
        id: 'vidit',
        color: 'bg-bubble',
        rotation: 'rotate-1',
        author: 'Vidit Gujrathi · Chess Grandmaster',
        avatar: '/images/landing/quote-vidit.jpg',
        text: 'Who said curiosity is just for kids? This is for anyone who still loves getting their mind blown.',
    },
    {
        id: 'kkcreate',
        color: 'bg-lime',
        rotation: '-rotate-1',
        author: 'Kavya Karnatac (KKCreate) · Content Creator & Educator',
        avatar: '/images/landing/quote-kkcreate.jpg',
        text: 'They make you see the obvious with brand-new eyes. Engaging, witty, and utterly unputdownable.',
    },
    {
        id: 'basu',
        color: 'bg-grape',
        rotation: 'rotate-1',
        author: 'Siddhartha Basu · Quizmaster & Creator of Kaun Banega Crorepati',
        avatar: '/images/landing/quote-basu.jpg',
        text: 'Nipun and Mohit lead you through a Wonderland of discovery — a joyride for the curious mind.',
    },
];
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
            <Quote :color="quotes[0].color" :rotation="quotes[0].rotation" :author="quotes[0].author" :avatar="quotes[0].avatar">
                “{{ quotes[0].text }}”
            </Quote>
            <About />
            <Quote :color="quotes[1].color" :rotation="quotes[1].rotation" :author="quotes[1].author" :avatar="quotes[1].avatar">
                “{{ quotes[1].text }}”
            </Quote>
            <Sample />
            <Quote :color="quotes[2].color" :rotation="quotes[2].rotation" :author="quotes[2].author" :avatar="quotes[2].avatar">
                “{{ quotes[2].text }}”
            </Quote>
            <TreasureHunt />
            <Quote :color="quotes[3].color" :rotation="quotes[3].rotation" :author="quotes[3].author" :avatar="quotes[3].avatar">
                “{{ quotes[3].text }}”
            </Quote>
            <SignedCopy />
            <Quote :color="quotes[4].color" :rotation="quotes[4].rotation" :author="quotes[4].author" :avatar="quotes[4].avatar">
                “{{ quotes[4].text }}”
            </Quote>
            <Order :variants="product.variants" />
            <Ticker v-if="reviews.length > 10" :reviews="reviews" />
            <Authors />
            <Quote :color="quotes[5].color" :rotation="quotes[5].rotation" :author="quotes[5].author" :avatar="quotes[5].avatar">
                “{{ quotes[5].text }}”
            </Quote>
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
