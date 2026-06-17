<script setup lang="ts">
import SectionBadge from '@/partials/Landing/SectionBadge.vue';

const thread = [
    { user: 'u/Mysterious-Year-3384', text: 'I saw some letters at random places, and perhaps they can spell out POLARIS. This could be something!' },
    { user: 'u/rest_in_war', text: 'Biggest hint got dropped today, which is the answer is NOT one word or sentence. It is a full page.' },
    { user: 'u/Ok-Mycologist-7816', text: "Feels like 'The secret is hiding in plain sight (i.e. PLAN SITE)'" },
    {
        user: 'u/bhavesh_ss1729',
        text: "For 6 whole days, I have been doing this and I have got nothing, I haven't watched a film or read a book. I sacrificed everything for 6 whole days, and I have got nothing. I AM DONE WITH THIS.",
    },
    {
        user: 'u/mohitmamoria [author]',
        verified: true,
        text: 'You all have figured out every individual piece of the puzzle; someone just needs to connect them in the right direction...',
    },
];
</script>

<template>
    <section class="mx-auto max-w-6xl px-5 py-12 md:py-20">
        <div class="relative overflow-hidden rounded-3xl border-2 border-ink bg-ink shadow-pop">
            <!-- Top bar label -->
            <div class="flex flex-col items-start gap-2 border-b-2 border-ink/30 bg-sun px-6 py-4 sm:flex-row sm:items-center sm:gap-3 sm:px-8">
                <span
                    class="inline-block -rotate-2 rounded-full border-2 border-ink bg-ink px-3 py-1 text-[0.7rem] font-bold tracking-wide whitespace-nowrap text-lime uppercase"
                    >Hidden inside every copy</span
                >
                <span class="flex items-center gap-2 text-xs font-bold text-ink/60">
                    <span class="inline-block h-2 w-2 animate-pulse rounded-full bg-green-600"></span>
                    Hunt is live
                </span>
            </div>

            <div class="p-8 md:p-14">
                <!-- Big prize announcement -->
                <div class="mb-12 text-center">
                    <p class="mb-4 text-xs font-bold tracking-[0.2em] text-lime uppercase">Real cash prize. No catch.</p>
                    <h2 class="font-fraunces text-6xl leading-tight font-semibold tracking-tight text-cream md:text-8xl">
                        Page 79 is<br /><span class="text-sun">missing.</span>
                    </h2>
                    <div class="relative mt-8 inline-block max-w-full rounded-2xl border-2 border-sun bg-sun/10 px-6 py-5 sm:px-10 sm:py-6">
                        <SectionBadge color="bg-sun" rotation="-rotate-3" class="absolute -top-3 -left-2 z-10 text-ink">Prize money</SectionBadge>
                        <p class="font-fraunces text-4xl font-bold whitespace-nowrap text-sun sm:text-6xl md:text-7xl">₹7,979.79</p>
                        <p class="mt-2 text-sm font-bold tracking-widest text-cream/70 uppercase">to whoever finds it first</p>
                    </div>
                    <p class="mx-auto mt-8 max-w-xl text-base leading-relaxed text-cream/80 md:text-lg">
                        One page has been intentionally removed from every single copy. No one knows where it went. The first reader to crack the
                        mystery wins real cash — transferred instantly.
                    </p>
                    <p class="mt-4 text-sm font-bold text-lime">Grab a friend. Grab your book. Start hunting together.</p>
                </div>

                <!-- Video + Reddit side by side -->
                <div class="grid gap-8 md:grid-cols-2">
                    <!-- VIDEO -->
                    <div>
                        <p class="mb-3 text-xs font-bold tracking-widest text-cream/50 uppercase">Watch the full story</p>
                        <div class="aspect-video w-full overflow-hidden rounded-2xl border-2 border-cream/20 bg-cream/5 shadow-stickersm">
                            <iframe
                                class="h-full w-full"
                                src="https://www.youtube.com/embed/76Va2caNrTk"
                                title="What the What — Page 79 treasure hunt"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen
                            ></iframe>
                        </div>
                    </div>

                    <!-- Reddit thread -->
                    <div>
                        <p class="mb-3 text-xs font-bold tracking-widest text-cream/50 uppercase">From the Reddit thread</p>
                        <div class="flex h-full flex-col justify-between rounded-2xl border-2 border-cream/20 bg-cream/5 p-5">
                            <div class="space-y-4">
                                <div
                                    v-for="(post, index) in thread"
                                    :key="post.user"
                                    :class="{ 'border-b border-cream/10 pb-3': index < thread.length - 1 }"
                                >
                                    <p class="text-xs font-bold" :class="post.verified ? 'text-sun' : 'text-lime'">{{ post.user }}</p>
                                    <p class="mt-1 text-sm text-cream/80">{{ post.text }}</p>
                                </div>
                            </div>
                            <a
                                href="https://wtw.is/79"
                                target="_blank"
                                rel="noopener"
                                class="mt-6 flex items-center justify-center gap-2 rounded-full border-2 border-lime bg-lime px-5 py-2.5 text-xs font-bold tracking-wide text-ink uppercase transition hover:bg-lime/80"
                            >
                                See the full thread on Reddit →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
