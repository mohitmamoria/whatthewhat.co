<script setup>
import { InfiniteScroll } from '@inertiajs/vue3';

const props = defineProps({
    wallet: {
        type: Object,
        default: null,
    },
    transactions: {
        type: Object,
        default: null,
    },
});
</script>

<template>
    <div class="border-b border-gray-200 pb-5">
        <h3 class="text-base font-semibold text-gray-900">Transactions</h3>
    </div>
    <ul role="list" class="divide-y divide-gray-100">
        <InfiniteScroll data="transactions">
            <li v-for="transaction in transactions.data" :key="transaction.id" class="relative flex items-center space-x-4 py-4">
                <div class="min-w-0 flex-auto">
                    <div class="flex items-center gap-x-3">
                        <div v-if="transaction.direction === 'credit'" class="flex-none rounded-full bg-green-100 p-1 text-green-500">
                            <div class="size-2 rounded-full bg-current"></div>
                        </div>
                        <div v-if="transaction.direction === 'debit'" class="flex-none rounded-full bg-rose-100 p-1 text-rose-500">
                            <div class="size-2 rounded-full bg-current"></div>
                        </div>
                        <h2 class="min-w-0 text-sm/6 font-semibold text-gray-900">
                            <p class="flex gap-x-2">
                                <span class="truncate"> {{ transaction.reason }} </span>
                            </p>
                        </h2>
                    </div>
                    <div class="mt-3 flex items-center gap-x-2.5 text-xs/5 text-gray-500">
                        <p class="whitespace-nowrap">{{ transaction.created_at }}</p>
                        <div v-if="transaction.meta_for_human" class="flex items-center gap-x-2.5">
                            <svg viewBox="0 0 2 2" class="size-0.5 flex-none fill-gray-500">
                                <circle cx="1" cy="1" r="1" />
                            </svg>
                            <p class="truncate">{{ transaction.meta_for_human }}</p>
                        </div>
                    </div>
                </div>
                <div
                    v-if="transaction.direction === 'debit'"
                    class="flex-none rounded-full bg-rose-50 px-2 py-1 text-xs font-medium text-rose-600 inset-ring inset-ring-rose-500/10"
                >
                    - {{ transaction.amount }} {{ wallet.currency_symbol }}
                </div>
                <div
                    v-if="transaction.direction === 'credit'"
                    class="flex-none rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 inset-ring inset-ring-green-700/10"
                >
                    + {{ transaction.amount }} {{ wallet.currency_symbol }}
                </div>
            </li>
        </InfiniteScroll>
    </ul>
</template>
