<script setup lang="ts"></script>

<template>
    <div class="bg-gray-50 py-24 sm:py-32">
        <div class="mx-auto max-w-2xl px-6 lg:max-w-7xl lg:px-8">
            <h2 class="text-center text-base/7 font-semibold text-purple-600">Good Good Goodies (only 500 available!!!)</h2>
            <p class="mx-auto mt-2 max-w-lg text-center text-4xl font-semibold tracking-tight text-balance text-gray-950 sm:text-5xl">
                Everything to tickle your curiosity
            </p>
            <div class="mt-10 grid gap-4 sm:mt-16 lg:grid-cols-3 lg:grid-rows-2">
                <div class="relative lg:row-span-2">
                    <div class="absolute inset-px rounded-lg bg-white lg:rounded-l-4xl" />
                    <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] lg:rounded-l-[calc(2rem+1px)]">
                        <div class="px-8 pt-8 pb-3 sm:px-10 sm:pt-10 sm:pb-0">
                            <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">The Book</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-600 max-lg:text-center">
                                250+ pages to tease and please your brain. That's <strong>What The What?!</strong>
                            </p>
                        </div>
                        <div class="@container relative min-h-120 w-full grow max-lg:mx-auto max-lg:max-w-sm">
                            <div
                                class="absolute inset-x-10 top-10 bottom-0 overflow-hidden rounded-t-[12cqw] border-x-[3cqw] border-t-[3cqw] border-gray-700 bg-gray-900 shadow-2xl"
                            >
                                <img
                                    class="size-full object-cover object-top"
                                    src="https://tailwindcss.com/plus-assets/img/component-images/bento-03-mobile-friendly.png"
                                    alt=""
                                />
                            </div>
                        </div>
                    </div>
                    <div class="pointer-events-none absolute inset-px rounded-lg shadow-sm outline outline-black/5 lg:rounded-l-4xl" />
                </div>
                <div class="relative max-lg:row-start-1">
                    <div class="absolute inset-px rounded-lg bg-white max-lg:rounded-t-4xl" />
                    <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] max-lg:rounded-t-[calc(2rem+1px)]">
                        <div class="px-8 pt-8 sm:px-10 sm:pt-10">
                            <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">Exclusive Bookmarks</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-600 max-lg:text-center">
                                A pair of exclusive <strong>two bookmarks</strong> that you will not get anywhere else, ever.
                            </p>
                        </div>
                        <div class="@container flex flex-1 items-center max-lg:py-6 lg:pb-2">
                            <img class="object-cover" src="/images/bookmarks.jpg" alt="" />
                        </div>
                    </div>
                    <div class="pointer-events-none absolute inset-px rounded-lg shadow-sm outline outline-black/5 max-lg:rounded-t-4xl" />
                </div>
                <div class="relative max-lg:row-start-3 lg:col-start-2 lg:row-start-2">
                    <div class="absolute inset-px rounded-lg bg-white" />
                    <div class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)]">
                        <div class="px-8 pt-8 sm:px-10 sm:pt-10">
                            <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">Special Quizwiz</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-600 max-lg:text-center">A special show of Quizwiz in January 2026</p>
                        </div>
                        <div class="@container flex flex-1 items-center max-lg:py-6 lg:pb-2">
                            <img class="object-cover" src="/images/special-quizwiz-show.png" alt="" />
                        </div>
                    </div>
                    <div class="pointer-events-none absolute inset-px rounded-lg shadow-sm outline outline-black/5" />
                </div>
                <div class="relative lg:row-span-2">
                    <div class="absolute inset-px rounded-lg bg-white max-lg:rounded-b-4xl lg:rounded-r-4xl" />
                    <div
                        class="relative flex h-full flex-col overflow-hidden rounded-[calc(var(--radius-lg)+1px)] max-lg:rounded-b-[calc(2rem+1px)] lg:rounded-r-[calc(2rem+1px)]"
                    >
                        <div class="px-8 pt-8 pb-3 sm:px-10 sm:pt-10 sm:pb-0">
                            <p class="mt-2 text-lg font-medium tracking-tight text-gray-950 max-lg:text-center">Jumbo Crossword</p>
                            <p class="mt-2 max-w-lg text-sm/6 text-gray-600 max-lg:text-center">
                                A crossword puzzle, beginner-friendly, but <strong>JUMBO!</strong>
                            </p>
                        </div>
                        <div class="@container flex flex-1 items-center max-lg:py-6 lg:pb-2">
                            <img class="object-cover" src="/images/jumbo-puzzle.png" alt="" />
                        </div>
                    </div>
                    <div
                        class="pointer-events-none absolute inset-px rounded-lg shadow-sm outline outline-black/5 max-lg:rounded-b-4xl lg:rounded-r-4xl"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
