<script setup lang="ts">
import Highlight from '@/partials/Landing/Highlight.vue';
</script>

<template>
    <section class="mx-auto max-w-6xl px-5 pt-32 pb-8 md:pt-40">
        <h1 class="mx-auto max-w-4xl text-center font-fraunces text-5xl leading-[1.02] font-semibold tracking-tight md:text-7xl">
            The strange-but-true facts hiding in <Highlight color="#ffd84d">plain sight</Highlight>.
        </h1>
        <p class="mx-auto mt-6 max-w-xl text-center text-base leading-relaxed text-muted md:text-lg">
            Meet <span class="font-bold text-ink">What the What</span> — a witty little field guide to the curious facts tucked inside the most
            ordinary corners of the world.
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
        <div class="relative mx-auto mt-14 max-w-4xl">
            <div class="absolute top-6 -left-2 z-20 -rotate-6 md:left-4">
                <span class="inline-block rounded-xl border-2 border-ink bg-sun px-3 py-2 text-[0.7rem] leading-tight font-bold shadow-stickersm"
                    >No.1 National<br />Bestseller!</span
                >
            </div>
            <div class="absolute top-2 -right-2 z-20 rotate-6 md:right-6">
                <span class="inline-block rounded-xl border-2 border-ink bg-grape px-3 py-2 text-[0.7rem] leading-tight font-bold shadow-stickersm"
                    >280 pages of<br />“wait, what?!”</span
                >
            </div>
            <div class="absolute bottom-8 left-2 z-20 -rotate-3 md:left-10">
                <span class="inline-block rounded-xl border-2 border-ink bg-bubble px-3 py-2 text-[0.7rem] leading-tight font-bold shadow-stickersm"
                    >Signed copy +<br />Free bookmark</span
                >
            </div>

            <div class="flex justify-center rounded-3xl border-2 border-ink bg-cream px-6 py-10 shadow-pop">
                <img src="/images/mockup-1.png" alt="The What the What book, standing upright" class="h-auto w-56 -rotate-2 md:w-72" />
            </div>
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
