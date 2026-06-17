<script setup lang="ts">
import { computed } from 'vue';
import Highlight from '@/partials/Landing/Highlight.vue';
import SectionBadge from '@/partials/Landing/SectionBadge.vue';

const colors = ['bg-lime', 'bg-sun', 'bg-sky', 'bg-grape', 'bg-bubble'];

const testimonials = [
    { quote: 'I picked it up to read one page and looked up an hour later. It ruins small talk forever — in the best way.', author: 'Aarav Mehta · Mumbai' },
    { quote: 'Finally, a book that makes you feel smart AND entertained. Worth every rupee.', author: 'Priya Sharma · Delhi' },
    { quote: 'Bought one, gifted four. The signed copy makes it feel like a proper little keepsake.', author: 'Rohan Iyer · Pune' },
    { quote: "Every page is a rabbit hole. I've already looked up 3 things at work because of this book.", author: 'Neha Kapoor · Bangalore' },
    { quote: 'This is the kind of book that makes you want to call your friends at midnight with random facts.', author: 'Vikram Singh · Hyderabad' },
    { quote: "I've recommended this to literally everyone I know. Best impulse buy ever.", author: 'Ananya Das · Kolkata' },
    { quote: 'Not just informative, but genuinely funny. My abs hurt from laughing while learning.', author: 'Arjun Reddy · Chennai' },
    { quote: "The perfect gift for people who think they know everything. They won't after this.", author: 'Sneha Patel · Ahmedabad' },
    { quote: 'Started reading at breakfast, finished by lunch. Then re-read it immediately.', author: 'Karan Verma · Jaipur' },
    { quote: 'This book is my new personality trait. I cannot stop talking about it.', author: 'Divya Gupta · Noida' },
    { quote: 'The hunt for page 79 has consumed my life and I have zero regrets.', author: 'Rajesh Kumar · Lucknow' },
    { quote: 'Such a clever concept. The writing is sharp, witty, and weirdly educational.', author: 'Isha Nair · Kochi' },
    { quote: 'My kids asked what I was laughing about every 5 minutes. Now they want a copy too.', author: 'Madhav Singh · Surat' },
    { quote: 'Supporting indie authors has never felt this rewarding. Love this book.', author: 'Aditi Mishra · Pune' },
    { quote: 'Proof that books can be both smart AND fun. A rare gem in today\'s world.', author: 'Sameer Khan · Gurgaon' },
];

// Duplicated for the seamless -50% loop.
const cards = computed(() => [...testimonials, ...testimonials]);
</script>

<template>
    <section class="py-12 md:py-16">
        <div class="mx-auto max-w-6xl px-5">
            <div class="mx-auto max-w-2xl text-center">
                <SectionBadge color="bg-bubble" rotation="-rotate-1">Readers love it</SectionBadge>
                <h2 class="mt-5 font-fraunces text-4xl font-semibold tracking-tight leading-tight md:text-5xl">
                    What people are <Highlight color="#a8d8ff">saying</Highlight>
                </h2>
            </div>
        </div>

        <!-- Full-bleed ticker -->
        <div class="ticker-wrap mt-12 py-4">
            <div class="ticker-track">
                <figure
                    v-for="(testimonial, index) in cards"
                    :key="index"
                    class="ticker-card rounded-3xl border-2 border-ink p-6 shadow-stickersm"
                    :class="colors[index % colors.length]"
                >
                    <blockquote class="font-fraunces text-lg font-medium italic leading-snug">"{{ testimonial.quote }}"</blockquote>
                    <figcaption class="mt-4 text-[0.65rem] font-bold tracking-wide uppercase">{{ testimonial.author }}</figcaption>
                </figure>
            </div>
        </div>
    </section>
</template>

<style scoped>
.ticker-wrap {
    overflow: hidden;
}

.ticker-track {
    display: flex;
    gap: 1.5rem;
    width: max-content;
    animation: ticker 60s linear infinite;
}

.ticker-track:hover {
    animation-play-state: paused;
}

@keyframes ticker {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.ticker-card {
    flex: 0 0 320px;
}
</style>
