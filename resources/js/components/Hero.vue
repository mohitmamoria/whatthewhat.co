<script setup>
// import { ChevronRightIcon } from '@heroicons/vue/20/solid';
</script>

<template>
    <div class="relative isolate overflow-hidden bg-white">
        <svg
            class="absolute inset-0 -z-10 size-full mask-[radial-gradient(100%_100%_at_top_right,white,transparent)] stroke-gray-200"
            aria-hidden="true"
        >
            <defs>
                <pattern id="983e3e4c-de6d-4c3f-8d64-b9761d1534cc" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                    <path d="M.5 200V.5H200" fill="none" />
                </pattern>
            </defs>
            <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
                <path d="M-200 0h201v201h-201Z M600 0h201v201h-201Z M-400 600h201v201h-201Z M200 800h201v201h-201Z" stroke-width="0" />
            </svg>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#983e3e4c-de6d-4c3f-8d64-b9761d1534cc)" />
        </svg>
        <div
            class="absolute top-10 left-[calc(50%-4rem)] -z-10 transform-gpu blur-3xl sm:left-[calc(50%-18rem)] lg:top-[calc(50%-30rem)] lg:left-48 xl:left-[calc(50%-24rem)]"
            aria-hidden="true"
        >
            <div
                class="aspect-1108/632 w-277 bg-linear-to-r from-[#80caff] to-[#4f46e5] opacity-20"
                style="
                    clip-path: polygon(
                        73.6% 51.7%,
                        91.7% 11.8%,
                        100% 46.4%,
                        97.4% 82.2%,
                        92.5% 84.9%,
                        75.7% 64%,
                        55.3% 47.5%,
                        46.5% 49.4%,
                        45% 62.9%,
                        50.3% 87.2%,
                        21.3% 64.1%,
                        0.1% 100%,
                        5.4% 51.1%,
                        21.4% 63.9%,
                        58.9% 0.2%,
                        73.6% 51.7%
                    );
                "
            />
        </div>
        <div class="mx-auto max-w-7xl px-6 pt-10 pb-24 sm:pb-32 lg:flex lg:px-8 lg:py-40">
            <div class="mx-auto max-w-2xl shrink-0 lg:mx-0 lg:pt-8">
                <img class="h-11" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&amp;shade=600" alt="Your Company" />

                <h1 class="mt-10 text-5xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-7xl">
                    Curious Questions. <br />
                    Curiouser Answers.
                </h1>
                <p class="mt-8 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">
                    Come along with us, down the rabbit hole that leads to a wonderful, weird and downright bizarre world of connections, trivia and
                    knowledge.
                </p>
                <p class="mt-8 text-lg font-medium text-pretty text-gray-500 sm:text-xl/8">
                    From everyday oddities to mind-bending wonders, every page promises to make you go: What The What?!
                </p>
                <div class="mt-10 flex items-center gap-x-6">
                    <a
                        href="#"
                        class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >Get started</a
                    >
                    <a href="#" class="text-sm/6 font-semibold text-gray-900">Learn more <span aria-hidden="true">→</span></a>
                </div>
            </div>
            <div class="mx-auto mt-16 flex max-w-2xl sm:mt-24 lg:mt-0 lg:mr-0 lg:ml-10 lg:max-w-none lg:flex-none xl:ml-32">
                <div class="max-w-3xl flex-none sm:max-w-5xl lg:max-w-none">
                    <img
                        src="/images/cover.jpeg"
                        alt="What The What?!"
                        class="mx-auto w-100 rounded-md bg-gray-50 shadow-lg ring-1 ring-gray-900/10"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
