<template>
    <div class="mt-12 bg-white py-12">
        <div class="mx-auto max-w-7xl lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-xl font-semibold text-indigo-600">🎁 🎁 🎁</h2>
                <p class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl lg:text-balance">Good Good Goodies</p>
                <p class="mt-6 text-lg/8 text-gray-600">
                    Strictly for the curious ones, we have prepared a pack of goodies to tease and please your brain for months to come.
                </p>
                <span
                    class="mx-auto mt-2 inline-flex items-center gap-x-1.5 rounded-full bg-white px-4 py-1 text-sm font-medium text-gray-900 inset-ring inset-ring-gray-200"
                >
                    <svg class="size-1.5 animate-ping fill-red-500" viewBox="0 0 6 6" aria-hidden="true">
                        <circle cx="3" cy="3" r="3" />
                    </svg>
                    Only 500 packs available.
                </span>
            </div>

            <div class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <ul role="list" class="divide-y divide-gray-200 xl:col-span-3">
                        <li
                            v-for="(feature, index) in features"
                            :key="feature.name"
                            class="flex flex-col gap-10 py-12 first:pt-0 last:pb-0 sm:flex-row"
                        >
                            <img
                                class="aspect-3/2 w-full flex-none rounded object-cover outline-1 -outline-offset-1 outline-black/5 sm:w-32"
                                :src="feature.image"
                                alt=""
                            />
                            <div class="max-w-xl flex-auto">
                                <span
                                    class="inline-flex items-center rounded-full bg-purple-50 px-1.5 py-0.5 text-xs font-medium text-purple-700 inset-ring inset-ring-purple-700/10"
                                    >🎁 Goodie #{{ index + 1 }}</span
                                >
                                <h3 class="text-lg/8 font-semibold tracking-tight text-gray-900">{{ feature.name }}</h3>
                                <p class="font-xs text-gray-500">worth ₹{{ feature.worth }}</p>
                                <p class="mt-6 text-base/7 text-gray-600">{{ feature.description }}</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="relative isolate mt-4 bg-white">
                <div class="px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h2 class="text-2xl tracking-tight text-balance text-gray-600">Total worth ₹997</h2>
                        <div class="-rotate-6 py-6">
                            <p class="mx-auto mt-6 max-w-xl font-serif text-5xl font-bold text-pretty text-gray-900 sm:text-7xl">FOR FREE!!!</p>
                            <p class="mx-auto mt-2 max-w-xl font-serif text-2xl font-bold text-pretty text-gray-900">on first 500 pre-orders</p>
                        </div>
                        <p
                            class="mx-auto inline max-w-xl rounded-full bg-yellow-300 px-4 py-2 font-serif text-sm font-bold text-pretty text-gray-900"
                        >
                            🚨 SELLING OUT FAAAASSSTTT!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const features = [
    {
        name: 'Jumbo Crossword',
        description: 'A beginner-friendly crossword—only giant-sized! A whopping 23×33 inches of pure puzzle JUMBO!',
        image: '/images/jumbo-puzzle.png',
        worth: '399.00',
    },
    {
        name: 'Exclusive Bookmarks',
        description: "A limited-edition pair of bookmarks—available only during this pre-order. Once it's over, they're gone for good!",
        image: '/images/bookmarks.jpg',
        worth: '99.00',
    },
    {
        name: 'Special Quizwiz',
        description: 'A special Quizwiz show that will run multiple times in January 2026, and you can join any one, using your free ticket.',
        image: '/images/special-quizwiz-show.png',
        worth: '499.00',
    },
];
</script>
