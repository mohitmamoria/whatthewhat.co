<script setup lang="ts">
import SectionBadge from '@/partials/Landing/SectionBadge.vue';
</script>

<template>
    <section class="mx-auto max-w-6xl px-5 py-12 md:py-20">
        <!-- Title -->
        <div class="mx-auto mb-16 max-w-2xl text-center">
            <SectionBadge color="bg-sun" rotation="rotate-2">Direct from authors</SectionBadge>
            <h2 class="mt-5 font-fraunces text-5xl font-semibold tracking-tight leading-tight md:text-6xl">A huge thank you</h2>
        </div>

        <div class="relative mx-auto w-full max-w-2xl">
            <!-- Speech bubbles row — one above each author -->
            <div class="flex items-end justify-between gap-4 px-2 md:px-8">
                <div
                    class="bubble-left relative max-w-[220px] flex-1 rounded-2xl border-2 border-ink bg-cream px-5 py-4 shadow-stickersm"
                    style="--bubble-bg: #faf8f2"
                >
                    <p class="text-sm font-medium leading-relaxed md:text-base">
                        Thank you for believing in us and buying directly. It means everything to keep publishing independently.
                    </p>
                    <p class="mt-2 font-fraunces text-sm font-bold">— Nipun</p>
                </div>
                <div
                    class="bubble-right relative max-w-[220px] flex-1 rounded-2xl border-2 border-ink bg-lime px-5 py-4 shadow-stickersm"
                    style="--bubble-bg: #c8f169"
                >
                    <p class="text-sm font-medium leading-relaxed md:text-base">
                        Every order funds our next project. You're not just buying a book — you're supporting our dream. Love you.
                    </p>
                    <p class="mt-2 font-fraunces text-sm font-bold">— Mohit</p>
                </div>
            </div>

            <!-- Author illustrations -->
            <div class="mt-2 flex items-end justify-center gap-6">
                <img src="/images/nipun-jain.png" alt="Nipun, co-author" class="w-40 object-contain md:w-52" />
                <img src="/images/mohit-mamoria.png" alt="Mohit, co-author" class="w-40 object-contain md:w-52" />
            </div>

            <!-- 100% note underneath -->
            <p class="mt-6 text-center text-base text-muted">
                No middlemen. No publisher cut. <span class="font-bold text-ink">100% of every rupee goes directly to us.</span>
            </p>
        </div>
    </section>
</template>

<style scoped>
/* Speech bubble tail — pointing down-left */
.bubble-left::after {
    content: '';
    position: absolute;
    bottom: -14px;
    left: 28px;
    border: 8px solid transparent;
    border-top-color: #1c1a17;
}

.bubble-left::before {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 30px;
    border: 6px solid transparent;
    border-top-color: var(--bubble-bg, #faf8f2);
    z-index: 1;
}

/* Speech bubble tail — pointing down-right */
.bubble-right::after {
    content: '';
    position: absolute;
    bottom: -14px;
    right: 28px;
    border: 8px solid transparent;
    border-top-color: #1c1a17;
}

.bubble-right::before {
    content: '';
    position: absolute;
    bottom: -10px;
    right: 30px;
    border: 6px solid transparent;
    border-top-color: var(--bubble-bg, #c8f169);
    z-index: 1;
}
</style>
