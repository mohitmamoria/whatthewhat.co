<script setup lang="ts">
import Highlight from '@/partials/Landing/Highlight.vue';
import SectionBadge from '@/partials/Landing/SectionBadge.vue';
</script>

<template>
    <section id="sample" class="mx-auto max-w-6xl px-5 py-12 md:py-16">
        <div class="grid items-center gap-10 md:grid-cols-2">
            <div class="order-2 -rotate-2 overflow-hidden rounded-3xl border-2 border-ink bg-cream p-3 shadow-pop md:order-1">
                <img src="/images/mockups/pile.jpg" alt="Pile of What The What books" class="h-full w-full rounded-2xl object-cover" />
            </div>
            <div class="order-1 md:order-2">
                <SectionBadge color="bg-bubble" rotation="rotate-2">Read a sample</SectionBadge>
                <h2 class="mt-5 font-fraunces text-4xl leading-tight font-semibold tracking-tight md:text-5xl">
                    Not sure what to expect? <Highlight color="#c8f169">Read it first.</Highlight>
                </h2>
                <p class="mt-6 text-base leading-relaxed text-muted md:text-lg">
                    We'll send you a few <span class="font-bold">deleted pages</span> — the ones that
                    <span class="font-bold underline">DID NOT</span> make it to the book. Read them on WhatsApp, and if your curiosity isn't hooked,
                    you've lost nothing but a few delightful minutes.
                </p>
                <div class="mt-7 rounded-2xl border-2 border-ink bg-cream p-6 shadow-sticker">
                    <p class="font-fraunces text-lg font-semibold">Get the free deleted pages</p>
                    <p class="mt-1 text-sm text-muted">Delivered straight to your WhatsApp.</p>
                    <a
                        href="https://wa.me/message/DQFIRJWQGDNQC1"
                        target="_blank"
                        rel="noopener"
                        class="mt-4 inline-flex rounded-full border-2 border-ink bg-lime px-6 py-3 text-xs font-bold tracking-wide uppercase shadow-stickersm transition hover:-translate-y-0.5 hover:shadow-sticker"
                    >
                        Send me the sample on WhatsApp →
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>
