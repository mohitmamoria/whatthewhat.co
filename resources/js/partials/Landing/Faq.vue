<script setup lang="ts">
import SectionBadge from '@/partials/Landing/SectionBadge.vue';

const faqs = [
    {
        question: 'When will I get my book?',
        answer: "We ship all orders within 1-2 business days of receiving them. Depending on your location, delivery usually takes 3–5 business days. You'll get a tracking link by email once your order ships.",
        open: true,
    },
    {
        question: 'Are the free pre-order goodies still available?',
        answer: 'The free pre-order goodies were available during the pre-order period exclusively. But, the signed edition and a bookmark are still included with every order while the stock lasts.',
        open: false,
    },
    {
        question: 'Do you ship internationally?',
        answer: 'Not yet — we currently ship within India only. International shipping is on the way, so join the list to hear first.',
        open: false,
    },
    {
        question: 'Can I change my shipping address?',
        answer: "No. Please make sure your address is correct before placing the order, as we're unable to change it once a copy has shipped. A valid Indian phone number that can receive OTP during the delivery is mandatory for a successful delivery.",
        open: false,
    },
    {
        question: 'What happens if I enter the wrong address?',
        answer: "If the order is undelivered, it gets returned to us. We'll reach out to you to confirm the correct address and ship it again (for an additional shipping fee). If the order is delivered to the wrong address, we can't be responsible for it. Please double-check your address before placing the order.",
        open: false,
    },

    {
        question: 'What happens if I am unable to receive the order for any reason?',
        answer: "At least two delivery attempts are made for every order. If the order is undelivered, it gets returned to us. We'll reach out to you to confirm the correct address and ship it again (for an additional shipping fee). If you would rather cancel the order, we can do that too, but shipping fee + returning fee (approx. ₹150) will be deducted from the refund amount.",
        open: false,
    },
    {
        question: 'Can I cancel my order?',
        answer: "Orders are processed immediately for shipping, so we're unable to accept cancellations once an order is placed.",
        open: false,
    },
    {
        question: 'What came first – chicken or egg?',
        answer: 'Whatever you ordered first, haha. (The real answer is on page 167.)',
        open: false,
    },
];
</script>

<template>
    <section id="faq" class="mx-auto max-w-5xl px-5 py-12 md:py-16">
        <div class="grid gap-8 md:grid-cols-[0.8fr_1.2fr]">
            <div>
                <SectionBadge color="bg-sun" rotation="rotate-2">Good to know</SectionBadge>
                <h2 class="mt-5 font-fraunces text-4xl leading-tight font-semibold tracking-tight md:text-5xl">Frequently asked questions</h2>
                <p class="mt-5 text-base text-muted">Have a question? Here are the answers to the things readers ask us most.</p>
            </div>
            <div class="space-y-3">
                <details
                    v-for="faq in faqs"
                    :key="faq.question"
                    class="group rounded-2xl border-2 border-ink bg-cream p-5 shadow-stickersm"
                    :open="faq.open"
                >
                    <summary class="flex items-start justify-between gap-4">
                        <span class="font-fraunces text-lg font-semibold">{{ faq.question }}</span>
                        <span class="faq-plus mt-1 text-xl">+</span>
                    </summary>
                    <p class="mt-3 pr-8 text-base text-muted">{{ faq.answer }}</p>
                </details>
            </div>
        </div>
    </section>
</template>

<style scoped>
details > summary {
    list-style: none;
    cursor: pointer;
}

details > summary::-webkit-details-marker {
    display: none;
}

details[open] .faq-plus {
    transform: rotate(45deg);
}

.faq-plus {
    transition: transform 0.25s ease;
}
</style>
