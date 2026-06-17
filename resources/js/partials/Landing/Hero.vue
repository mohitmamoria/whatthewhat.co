<script setup lang="ts">
import Highlight from '@/partials/Landing/Highlight.vue';
</script>

<template>
    <section class="mx-auto max-w-6xl px-5 pt-32 pb-8 md:pt-40">
        <h1 class="mx-auto max-w-4xl text-center font-fraunces text-5xl leading-[1.02] font-semibold tracking-tight md:text-7xl">
            The strange-but-true facts hiding in <Highlight color="#ffd84d">plain sight</Highlight>.
        </h1>
        <p class="mx-auto mt-6 max-w-xl text-center text-base leading-relaxed text-muted md:text-lg">
            Meet <span class="font-bold text-ink">What the What</span> — a witty little book of the curious facts and trivia tucked inside the most
            ordinary things and people of the world.
        </p>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <a
                href="#order"
                class="rounded-full border-2 border-ink bg-lime px-7 py-3 text-sm font-bold tracking-wide uppercase shadow-sticker transition hover:-translate-y-0.5 hover:shadow-pop"
            >
                Buy the book → ₹299
            </a>
            <a
                href="#sample"
                class="rounded-full border-2 border-ink bg-cream px-7 py-3 text-sm font-bold tracking-wide uppercase shadow-stickersm transition hover:-translate-y-0.5 hover:shadow-sticker"
            >
                Read a sample
            </a>
        </div>

        <!-- collage -->
        <div class="relative mx-auto mt-14 w-fit">
            <img
                src="/images/what-the-what-national-bestseller.png"
                alt="What the What book, standing upright"
                class="mx-auto h-auto w-64 -rotate-2 drop-shadow-2xl sm:w-80 md:w-[26rem]"
            />
        </div>

        <!-- stat row -->
        <div class="mx-auto mt-12 grid max-w-3xl grid-cols-3 gap-3">
            <div class="rounded-2xl border-2 border-ink bg-cream p-4 text-center shadow-stickersm">
                <p class="font-fraunces text-3xl font-bold">280</p>
                <p class="mt-1 text-[0.65rem] tracking-wide text-muted uppercase">curious pages</p>
            </div>
            <div class="rounded-2xl border-2 border-ink bg-lime p-4 text-center shadow-stickersm">
                <p class="font-fraunces text-3xl font-bold">No.1</p>
                <p class="mt-1 text-[0.65rem] tracking-wide text-ink/70 uppercase">national bestseller</p>
            </div>
            <div class="rounded-2xl border-2 border-ink bg-cream p-4 text-center shadow-stickersm">
                <p class="font-fraunces text-3xl font-bold">4.8<span class="text-xl">/5</span></p>
                <p class="mt-1 text-[0.65rem] tracking-wide text-muted uppercase">⭐ star rating</p>
            </div>
        </div>
    </section>
</template>
