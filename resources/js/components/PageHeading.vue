<template>
    <div class="mb-5 border-b border-gray-200 pb-5">
        <h3 class="text-base font-semibold text-gray-900">
            <slot></slot>
        </h3>
        <p class="mt-2 max-w-4xl text-sm text-gray-500">
            <slot name="description" />
        </p>
    </div>
</template>
