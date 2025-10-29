<script setup lang="ts">
import Narrow from '@/layouts/Narrow.vue';
import { ChevronDownIcon } from '@heroicons/vue/16/solid';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    countries: {
        type: Array,
        required: true,
    },
});

const page = usePage();
const next = computed(() => {
    const url = new URL(page.url, window.location.origin);
    return url.searchParams.get('next');
});

const form = useForm({
    country: 'IN',
    phone: '',
    otp: '',
    next: next.value || '',
});

const resendCounter = ref(0);
const startResendCounter = () => {
    resendCounter.value = 60;
    const interval = setInterval(() => {
        if (resendCounter.value > 0) {
            resendCounter.value--;
        } else {
            clearInterval(interval);
        }
    }, 1000);
};

const isOTPSent = ref(false);
const sendOTP = () => {
    form.post(route('auth.player.otp'), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            isOTPSent.value = true;
            startResendCounter();
        },
    });
};

const verifyOTP = () => {
    form.post(route('auth.player.verify'), {
        preserveScroll: true,
        preserveState: true,
    });
};

const submit = () => {
    if (!isOTPSent.value) {
        sendOTP();
    } else {
        verifyOTP();
    }
};
</script>

<template>
    <Head title="Login to continue"></Head>
    <Narrow>
        <div class="relative isolate px-6 lg:px-8">
            <div class="mx-auto max-w-2xl">
                <div class="">
                    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
                        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                            <form class="space-y-6" @submit.prevent="submit">
                                <div>
                                    <div class="flex items-center justify-between">
                                        <label for="phone" class="block text-sm/6 font-medium text-gray-900">WhatsApp number</label>
                                        <div class="text-sm" v-if="isOTPSent">
                                            <form @submit.prevent="sendOTP">
                                                <button type="submit" class="text-pink-600 hover:text-pink-500" :disabled="resendCounter > 0">
                                                    Resend <span v-if="resendCounter > 0">in {{ resendCounter }}s</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div>
                                            <div class="mt-2">
                                                <div
                                                    class="flex rounded-md bg-white outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-pink-600"
                                                >
                                                    <div class="grid shrink-0 grid-cols-1 focus-within:relative">
                                                        <select
                                                            id="country"
                                                            name="country"
                                                            v-model="form.country"
                                                            autocomplete="country"
                                                            aria-label="Country"
                                                            class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-7 pl-3 text-base text-gray-500 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-pink-600 sm:text-sm/6"
                                                        >
                                                            <option v-for="country in countries" :value="country.alpha_2" :key="country.alpha_2">
                                                                {{ country.alpha_2 }} {{ country.flag }} ({{ country.isd }})
                                                            </option>
                                                        </select>
                                                        <ChevronDownIcon
                                                            class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                                            aria-hidden="true"
                                                        />
                                                    </div>
                                                    <input
                                                        type="tel"
                                                        name="phone"
                                                        id="phone"
                                                        autocomplete="phone"
                                                        required
                                                        v-model="form.phone"
                                                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                                        placeholder="9876543210"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <input
                                            type="tel"
                                            name="phone"
                                            id="phone"
                                            autocomplete="phone"
                                            required
                                            v-model="form.phone"
                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-pink-600 sm:text-sm/6"
                                        /> -->
                                        <p v-if="form.errors.phone" class="mt-2 text-sm/6 text-red-600">{{ form.errors.phone }}</p>
                                    </div>
                                </div>

                                <div v-if="isOTPSent">
                                    <div class="flex items-center justify-between">
                                        <label for="otp" class="block text-sm/6 font-medium text-gray-900">OTP</label>
                                    </div>
                                    <div class="mt-2">
                                        <input
                                            type="text"
                                            inputmode="numeric"
                                            autocomplete="one-time-code"
                                            pattern="\d{6}"
                                            name="otp"
                                            id="otp"
                                            v-model="form.otp"
                                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-pink-600 sm:text-sm/6"
                                        />
                                    </div>
                                    <p v-if="form.errors.otp" class="mt-2 text-sm/6 text-red-600">{{ form.errors.otp }}</p>
                                </div>

                                <div>
                                    <button
                                        type="submit"
                                        class="flex w-full justify-center rounded-md bg-pink-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-pink-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pink-600"
                                    >
                                        {{ isOTPSent ? 'Verify' : 'Send OTP' }}
                                    </button>
                                </div>
                                <div v-if="isOTPSent">
                                    <p class="mt-2 text-sm/6 text-gray-600">OTP has been sent. Please check your WhatsApp.</p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Narrow>
</template>
