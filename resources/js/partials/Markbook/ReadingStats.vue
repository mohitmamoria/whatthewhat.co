<script setup>
const props = defineProps({
    stats: {
        type: Object,
        required: true,
    },
});

const stats = [
    { name: 'Pages read', value: props.stats.total_pages_read },
    { name: 'Books read', value: props.stats.total_books_read },
    { name: 'Last reading', value: props.stats.last_reading_pages, unit: 'pages' },
];
</script>

<template>
    <div class="m-4 bg-white">
        <div class="mx-auto max-w-7xl">
            <div class="grid grid-cols-1 gap-px bg-gray-900/5 sm:grid-cols-1 lg:grid-cols-3">
                <div v-for="stat in stats" :key="stat.name" class="bg-white px-4 py-6 sm:px-6 lg:px-8">
                    <p class="text-sm/6 font-medium text-gray-500">{{ stat.name }}</p>
                    <p class="mt-2 flex items-baseline gap-x-2">
                        <span class="text-4xl font-semibold tracking-tight text-gray-900">{{ stat.value }}</span>
                        <span v-if="stat.unit" class="text-sm text-gray-500">{{ stat.unit }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
