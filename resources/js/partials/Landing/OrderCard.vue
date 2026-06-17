<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    variant: {
        type: Object,
        required: true,
    },
    badge: {
        type: String,
        default: null,
    },
    cutoutPrice: {
        type: Number,
        default: null,
    },
});

const form = useForm({
    ref: usePage().props.ref,
    variant: props.variant.id,
    quantity: 1,
});

const discount = computed<number | null>(() => {
    if (!props.cutoutPrice) {
        return null;
    }

    return Math.round((1 - props.variant.price / props.cutoutPrice) * 100);
});

const decrement = (): void => {
    if (form.quantity > 1) {
        form.quantity--;
    }
};

const increment = (): void => {
    if (form.quantity < 10) {
        form.quantity++;
    }
};

const checkout = (): void => {
    form.post(route('shop.checkout'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <article
        class="mx-auto w-full max-w-xl overflow-hidden rounded-3xl border-2 border-ink bg-cream shadow-pop md:flex-1"
        :class="{ 'opacity-75': !variant.is_available }"
    >
        <div class="flex items-center gap-5 border-b-2 border-ink bg-lime p-6">
            <img
                :src="`/images/${variant.sku}-desktop.jpg`"
                :alt="variant.title"
                class="h-24 w-24 shrink-0 rounded-xl border-2 border-ink object-cover"
                :class="{ grayscale: !variant.is_available }"
            />
            <div>
                <span
                    v-if="!variant.is_available"
                    class="inline-block rounded-full border-2 border-ink bg-ink px-2 py-0.5 text-[0.6rem] font-bold tracking-wide text-cream uppercase"
                    >Out of stock</span
                >
                <span
                    v-else-if="badge"
                    class="inline-block rounded-full border-2 border-ink bg-cream px-2 py-0.5 text-[0.6rem] font-bold tracking-wide uppercase"
                    >{{ badge }}</span
                >
                <h3 class="mt-1.5 font-fraunces text-2xl font-bold">For {{ variant.title }}</h3>
                <p class="text-sm text-ink/70">The signed book + free bookmark.</p>
            </div>
        </div>
        <div class="flex flex-1 flex-col p-6">
            <div v-if="variant.description" class="variant-desc text-base" v-html="variant.description"></div>

            <div class="mt-auto flex items-end gap-3 pt-6">
                <span class="font-fraunces text-4xl font-bold">₹{{ variant.price }}</span>
                <span v-if="cutoutPrice" class="mb-1 text-base text-muted line-through">₹{{ cutoutPrice }}</span>
                <span v-if="discount" class="mb-1 rounded-full border-2 border-ink bg-sun px-2 py-0.5 text-xs font-bold">{{ discount }}% off</span>
            </div>

            <form v-if="variant.is_available" class="mt-6 flex items-center justify-between gap-4" @submit.prevent="checkout">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        class="grid h-9 w-9 place-items-center rounded-full border-2 border-ink bg-cream text-lg font-bold shadow-stickersm transition hover:-translate-y-0.5 disabled:opacity-40"
                        :disabled="form.quantity <= 1"
                        @click="decrement"
                    >
                        −
                    </button>
                    <span class="w-6 text-center font-bold">{{ form.quantity }}</span>
                    <button
                        type="button"
                        class="grid h-9 w-9 place-items-center rounded-full border-2 border-ink bg-cream text-lg font-bold shadow-stickersm transition hover:-translate-y-0.5 disabled:opacity-40"
                        :disabled="form.quantity >= 10"
                        @click="increment"
                    >
                        +
                    </button>
                </div>
                <button
                    type="submit"
                    class="flex-1 rounded-full border-2 border-ink bg-ink px-6 py-3 text-center text-xs font-bold tracking-wide text-lime uppercase transition hover:-translate-y-0.5 hover:shadow-sticker disabled:opacity-60"
                    :disabled="form.processing"
                >
                    Add to cart · ₹{{ form.quantity * variant.price }}
                </button>
            </form>
            <div
                v-else
                class="mt-6 cursor-not-allowed rounded-full border-2 border-ink bg-ink/10 px-6 py-3 text-center text-xs font-bold tracking-wide text-ink/50 uppercase"
            >
                Out of stock
            </div>
        </div>
    </article>
</template>

<style scoped>
/* Render the variant description (HTML from the backend) as the green checklist. */
.variant-desc :deep(ul) {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.variant-desc :deep(li) {
    position: relative;
    padding-left: 2rem;
    line-height: 1.4;
}

.variant-desc :deep(li)::before {
    content: '✓';
    position: absolute;
    top: 0.05rem;
    left: 0;
    display: grid;
    place-items: center;
    height: 1.25rem;
    width: 1.25rem;
    border: 2px solid var(--color-ink);
    border-radius: 9999px;
    background: var(--color-lime);
    font-size: 0.7rem;
}

.variant-desc :deep(p) {
    font-weight: 700;
}

.variant-desc :deep(p:not(:first-child)) {
    margin-top: 0.75rem;
}

.variant-desc :deep(ul:not(:first-child)) {
    margin-top: 0.75rem;
}

.variant-desc :deep(a) {
    text-decoration: underline;
    text-underline-offset: 2px;
}
</style>
