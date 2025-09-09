<script setup>
import { ref } from 'vue';

const navigation = [
    { name: 'Product', href: '#' },
    { name: 'Features', href: '#' },
    { name: 'Marketplace', href: '#' },
    { name: 'Company', href: '#' },
];

const mobileMenuOpen = ref(false);
</script>

<template>
    <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-50">header</header>

        <div class="relative isolate pt-14">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                <div
                    class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75"
                    style="
                        clip-path: polygon(
                            74.1% 44.1%,
                            100% 61.6%,
                            97.5% 26.9%,
                            85.5% 0.1%,
                            80.7% 2%,
                            72.5% 32.5%,
                            60.2% 62.4%,
                            52.4% 68.1%,
                            47.5% 58.3%,
                            45.2% 34.5%,
                            27.5% 76.7%,
                            0.1% 64.9%,
                            17.9% 100%,
                            27.6% 76.8%,
                            76.1% 97.7%,
                            74.1% 44.1%
                        );
                    "
                />
            </div>
            <div class="py-24 sm:py-32 lg:pb-40">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h1 class="font-brand text-4xl tracking-tight text-balance text-gray-900 sm:text-5xl">
                            Curious Questions. <br />
                            Even Curiouser Answers.
                        </h1>
                        <p class="mt-8 text-lg font-medium text-pretty text-gray-700 sm:text-xl/8">
                            This is not a book of quizzes. This is not a book of facts.
                        </p>
                        <p class="mt-8 text-lg font-medium text-pretty text-gray-700 sm:text-xl/8">It's both — and so much more!</p>
                    </div>

                    <img src="/images/mockup-1.png" alt="What The What?!" class="mx-auto mt-8 w-xl rounded-md" />
                </div>
            </div>
        </div>
    </div>
</template>
