<script setup lang="ts">
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue';
import { XMarkIcon } from '@heroicons/vue/20/solid';
import { ref, watch } from 'vue';

const props = defineProps({
    review: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['close']);

// Keeps the last review rendered while the dialog plays its leave transition —
// `review` itself is cleared to close the dialog, but the panel needs content
// to fade out with instead of unmounting mid-transition.
const displayedReview = ref(props.review);
watch(
    () => props.review,
    (value) => {
        if (value) {
            displayedReview.value = value;
        }
    },
);

const stars = (rating: number): string => '⭐'.repeat(rating);
</script>

<template>
    <TransitionRoot appear :show="!!review" as="template">
        <Dialog as="div" class="relative z-50" @close="emit('close')">
            <TransitionChild
                as="template"
                enter="duration-200 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-150 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-ink/40" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-200 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-150 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            v-if="displayedReview"
                            class="relative w-full max-w-md rounded-3xl border-2 border-ink bg-cream p-6 text-left shadow-pop"
                        >
                            <button
                                type="button"
                                class="absolute top-4 right-4 rounded-full border-2 border-ink bg-paper p-1 hover:bg-sun"
                                @click="emit('close')"
                            >
                                <XMarkIcon class="size-4" />
                                <span class="sr-only">Close</span>
                            </button>

                            <p class="text-sm leading-none">{{ stars(displayedReview.rating) }}</p>
                            <p v-if="displayedReview.title" class="mt-3 font-fraunces text-lg leading-snug font-semibold">
                                {{ displayedReview.title }}
                            </p>
                            <blockquote class="mt-2 font-fraunces text-base leading-snug font-medium break-words italic">
                                "{{ displayedReview.quote }}"
                            </blockquote>
                            <p class="mt-4 text-[0.65rem] font-bold tracking-wide uppercase">{{ displayedReview.author }} · Verified reader</p>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
