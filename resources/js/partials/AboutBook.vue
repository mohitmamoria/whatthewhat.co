<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="rounded-xl bg-linear-to-b from-yellow-200 to-yellow-100 text-center">
        <img src="/images/what-the-what-logo.svg" alt="What The What?! Logo" class="mx-auto h-16 w-auto py-2 sm:h-24" />

        <img src="/images/mockup-1.png" alt="What The What?!" class="mx-auto w-xs rounded-md" />
        <span
            class="mx-auto mt-2 inline-flex items-center gap-x-1.5 rounded-full bg-white px-4 py-1 text-sm font-medium text-gray-900 inset-ring inset-ring-gray-200"
        >
            <svg class="size-1.5 animate-pulse fill-green-500" viewBox="0 0 6 6" aria-hidden="true">
                <circle cx="3" cy="3" r="3" />
            </svg>
            Releasing on 25.11.25
        </span>
        <div class="relative mx-auto w-full text-center">
            <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] max-lg:rounded-t-[calc(2rem+1px)]">
                <div class="px-4 pt-4 pb-12 font-serif text-xl font-bold sm:px-10">
                    <p>It's not a quiz book. It's not a fact book.</p>

                    <p class="mt-4">It's both&mdash;and more!</p>

                    <div class="mt-4 flex items-center justify-center gap-2">
                        <a
                            href="https://wtw.is/amazon"
                            class="inline-block rounded-md bg-pink-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-pink-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600"
                        >
                            Buy for yourself &rarr;
                        </a>

                        <Link
                            :href="route('shop.gift')"
                            class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-xs inset-ring inset-ring-gray-300 hover:bg-gray-50"
                        >
                            Gift to the world &rarr;
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <article class="prose mt-12 prose-stone prose-p:font-serif">
        <div class="text-center text-lg font-bold">
            <p>No factories, no exports—yet a tiny island makes millions?!</p>
            <p>A deadly weapon is named after a common fruit?!</p>
            <p>Even geniuses make silly mistakes like the rest of us?!</p>
        </div>

        <p class="text-center">* * *</p>

        <p>
            These may seem like strange stories, but they are actually curious little facts about things or people that we're all very familiar with.
            Once you find the answers to these, you'll go… <strong>WHAT THE WHAT?!</strong>
        </p>

        <p>
            Join <a href="http://instagram.com/nipunnyy" target="_blank">Nipun</a> and
            <a href="http://instagram.com/mohitmamoria" target="_blank">Mohit</a>, the brains behind
            <a href="https://www.youtube.com/@areypatahai" target="_blank">Arey Pata Hai</a>—the channel that turned curiosity into a movement—as they
            journey across the pages of this book, with their boundless hunger for knowledge and a gift for storytelling and bad
            <em>(phenomenal!)</em>
            jokes, they'll lead you on an unforgettable journey.&nbsp;
        </p>
    </article>
</template>
