<template>
    <div class="bg-white py-12">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base/7 font-semibold text-indigo-600">🎁 Good Good Goodies (only 500 available!!!)</h2>
                <p class="mt-2 text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl lg:text-balance">
                    Everything to tickle your curiosity
                </p>
                <p class="mt-6 text-lg/8 text-gray-600">
                    Strictly for the curious ones out there, we have prepared a pack that will tease and please your brain for months to come.
                </p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                    <div v-for="feature in features" :key="feature.name" class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base/7 font-semibold text-gray-900">
                            {{ feature.name }}
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base/7 text-gray-600">
                            <p class="flex-auto">{{ feature.description }}</p>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</template>

<script setup>
const features = [
    {
        name: '🧩 Jumbo Crossword',
        description: 'A crossword puzzle, which is beginner-friendly, but really huge (23x33in) in size. JUMBO!',
    },
    {
        name: '📚 Exclusive Bookmarks',
        description: 'A pair of exclusive two bookmarks that you will not get anywhere else, ever, except during this pre-order period.',
    },
    {
        name: '🎪 Special Quizwiz',
        description: 'A free ticket to a very special Quizwiz show in January 2025. A show like nothing before!',
    },
];
</script>
