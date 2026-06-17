<script setup lang="ts">
import Highlight from '@/partials/Landing/Highlight.vue';
import SectionBadge from '@/partials/Landing/SectionBadge.vue';
</script>

<template>
    <section class="mx-auto max-w-6xl px-5 py-12 md:py-16">
        <div class="grid items-center gap-10 md:grid-cols-2">
            <div>
                <SectionBadge color="bg-bubble" rotation="-rotate-2">Special touches</SectionBadge>
                <h2 class="mt-5 font-fraunces text-4xl leading-tight font-semibold tracking-tight md:text-5xl">
                    Hand-signed by both <Highlight color="#c8f169">authors</Highlight> + free bookmark
                </h2>
                <p class="mt-6 text-base leading-relaxed text-muted md:text-lg">
                    Every copy ordered on this website carries signatures from both Nipun and Mohit on the title page.
                </p>
                <p class="mt-6 text-base leading-relaxed text-muted md:text-lg">
                    Plus, you get a beautifully designed free custom bookmark tucked inside — featuring a special trivia on it.
                </p>
                <a
                    href="#order"
                    class="mt-7 inline-flex items-center gap-2 rounded-full border-2 border-ink bg-lime px-5 py-2.5 text-xs font-bold tracking-wide uppercase shadow-stickersm transition hover:-translate-y-0.5 hover:shadow-sticker"
                >
                    Order now <span aria-hidden="true">→</span>
                </a>
            </div>
            <div class="rotate-1 overflow-hidden rounded-3xl border-2 border-ink bg-cream p-3 shadow-pop">
                <img
                    src="/images/landing/wtw-free-bookmarks.png"
                    alt="Hand-signed book with letterpress bookmark"
                    class="h-full w-full rounded-2xl object-cover"
                />
            </div>
        </div>
    </section>
</template>
