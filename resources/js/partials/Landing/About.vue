<script setup lang="ts">
import Highlight from '@/partials/Landing/Highlight.vue';
import SectionBadge from '@/partials/Landing/SectionBadge.vue';
</script>

<template>
    <section id="about" class="mx-auto max-w-6xl px-5 py-12 md:py-16">
        <div class="grid items-start gap-10 md:grid-cols-2">
            <div>
                <SectionBadge color="bg-sun" rotation="-rotate-2">What it's about</SectionBadge>
                <h2 class="mt-5 font-fraunces text-4xl leading-tight font-semibold tracking-tight md:text-5xl">
                    Strange-but-true facts hiding in <Highlight color="#ffb3d1">plain sight</Highlight>
                </h2>
                <div class="mt-6 space-y-4 text-base leading-relaxed text-muted md:text-lg">
                    <p>
                        <span class="font-bold text-ink">What The What?!</span> is a book of curious stories, strange facts, forgotten histories, odd
                        inventions, bizarre coincidences, and everyday things that are far weirder than they seem.
                    </p>
                    <p>Open it anywhere, and you’ll find something surprising enough to tell someone else.</p>
                </div>
                <a
                    href="#order"
                    class="mt-7 inline-flex items-center gap-2 rounded-full border-2 border-ink bg-lime px-5 py-2.5 text-xs font-bold tracking-wide uppercase shadow-stickersm transition hover:-translate-y-0.5 hover:shadow-sticker"
                >
                    Get your copy <span aria-hidden="true">→</span>
                </a>
            </div>
            <ul class="grid gap-4">
                <li class="rotate-1 rounded-2xl border-2 border-ink bg-cream p-6 shadow-stickersm">
                    <p class="font-fraunces text-xl font-semibold">Strange but true</p>
                    <p class="mt-2 text-base text-muted">Bite-sized stories you'll want to read aloud to whoever's nearest.</p>
                </li>
                <li class="-rotate-1 rounded-2xl border-2 border-ink bg-sky p-6 shadow-stickersm">
                    <p class="font-fraunces text-xl font-semibold">Built for curious minds</p>
                    <p class="mt-2 text-base text-ink/70">Short chapters, sharp wit, and a fact on every page worth remembering.</p>
                </li>
                <li class="rotate-1 rounded-2xl border-2 border-ink bg-cream p-6 shadow-stickersm">
                    <p class="font-fraunces text-xl font-semibold">Made to be gifted</p>
                    <p class="mt-2 text-base text-muted">The kind of book people borrow and conveniently forget to return.</p>
                </li>
            </ul>
        </div>
    </section>
</template>
