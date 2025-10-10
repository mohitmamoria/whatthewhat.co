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
        answer: 'We will start shipping from 19 November 2025. Based on your location, it may take 5-6 days to reach you. In most cases, you will get the book by 25 November 2025.',
    },
    {
        id: 2,
        question: 'How do I know if I got the goodies?',
        answer: 'If you were able to place an order on this website, you are <strong>100000%</strong> getting the goodies. Whenever we will be unable to get more goodies, we will stop accepting orders. So, if you were able to place an order, you are definitely getting the goodies.',
    },
    {
        id: 3,
        question: 'I have not received the pre-order link yet. Why?',
        answer: 'Perhaps due to WhatsApp limitations. You can email us at community@areypatahai.com with your phone number and we will send you the link.',
    },
    {
        id: 4,
        question: 'Can I change my shipping address after placing the order?',
        answer: 'You can request a change in shipping address by filling out this <a href="https://forms.gle/tuBYe4K3rxUSpgvSA" class="font-bold underline">form</a> within 24 hours of placing your order.',
    },
    {
        id: 5,
        question: 'Can I cancel my order?',
        answer: 'We are procuring the books and goodies based on the orders we receive, and are directly processed by our suppliers automatically. Hence, we are unable to cancel any orders.',
    },
    {
        id: 6,
        question: 'Why did chicken cross the road?',
        answer: 'To tell its friends that the book is awesome! 🐔',
    },
];
</script>
