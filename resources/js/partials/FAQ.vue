<template>
    <div class="bg-white font-serif">
        <div class="mx-auto max-w-7xl px-6 py-16 sm:py-24 lg:px-8">
            <h2 class="text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">Frequently asked questions</h2>
            <p class="mt-6 max-w-2xl text-base/7 text-gray-600">Have a question? Here are the answers to all your questions.</p>
            <div class="mt-20">
                <dl class="space-y-16 sm:grid sm:grid-cols-1 sm:space-y-0 sm:gap-x-6 sm:gap-y-16 lg:grid-cols-1 lg:gap-x-10">
                    <div v-for="faq in faqs" :key="faq.id">
                        <dt class="text-base/7 font-semibold text-gray-900">{{ faq.question }}</dt>
                        <dd class="mt-2 text-base/7 text-gray-600" v-html="faq.answer"></dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</template>

<script setup>
const faqs = [
    {
        id: 1,
        question: 'When will I get my book?',
        answer: 'We ship all orders within 24 business hours of receiving your order. Depending on your location, delivery usually takes 3-7 business days within India. You will receive a tracking link via email and WhatsApp once your order is shipped.',
    },
    {
        id: 2,
        question: 'Are the free goodies still available?',
        answer: 'No. They were exclusive to pre-orders before the book was released.',
    },
    {
        id: 3,
        question: 'Do you ship internationally?',
        answer: 'No, we do not ship internationally.',
    },
    {
        id: 4,
        question: 'Can I change my shipping address after placing the order?',
        answer: 'No. Please ensure that your shipping address is correct before placing the order as we are unable to make any changes once the order is placed, and it should have an Indian phone number to receive OTP during the delivery.',
    },
    {
        id: 5,
        question: 'Can I cancel my order?',
        answer: 'No, we do not accept cancellations. Once an order is placed, it is processed immediately for shipping.',
    },
    {
        id: 6,
        question: 'Why did chicken cross the road?',
        answer: 'To tell its friends that the book is awesome! 🐔',
    },
];
</script>
