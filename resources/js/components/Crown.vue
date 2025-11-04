<script setup>
import { computed } from 'vue';
const props = defineProps({
    position: {
        type: Number,
        required: true,
    },
});

const color = computed(() => {
    if (props.position === 1) {
        return '#FEDA2A';
    }

    if (props.position === 2) {
        return '#C0C0C0';
    }

    if (props.position === 3) {
        return '#CC6F3A';
    }
});
</script>
<template>
    <span v-if="position > 3" class="text-sm text-gray-100"><span class="text-[0.5rem]">#</span>{{ position }}</span>
    <svg v-else class="h-full w-full" viewBox="0 0 45 45" xmlns="http://www.w3.org/2000/svg">
        <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M21.0994 18C19.4611 20.7733 18.2052 21.1258 16.6486 19.25C14.9444 17.1958 13.5069 17.7408 13.8977 20.2917C14.8986 26.8125 14.1577 26.3333 23.2419 26.3333C32.3036 26.3333 32.4819 26.2275 32.4819 20.8483C32.4819 17.7875 31.6411 17.25 29.9819 19.25C28.4252 21.1258 27.1694 20.7733 25.5311 18C24.7186 16.625 23.7219 15.5 23.3152 15.5C22.9086 15.5 21.9119 16.625 21.0994 18ZM14.9819 28.8333C14.9819 30.3892 15.5377 30.5 23.3152 30.5C31.0927 30.5 31.6486 30.3892 31.6486 28.8333C31.6486 27.2775 31.0927 27.1667 23.3152 27.1667C15.5377 27.1667 14.9819 27.2775 14.9819 28.8333Z"
            :fill="color"
        />
        <g filter="url(#filter0_f_382_1216)">
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M20.2041 16.1667C18.1289 19.6796 16.5381 20.1261 14.5664 17.75C12.4077 15.1481 10.5869 15.8384 11.082 19.0694C12.3497 27.3292 11.4113 26.7222 22.9179 26.7222C34.396 26.7222 34.6219 26.5882 34.6219 19.7746C34.6219 15.8975 33.5569 15.2167 31.4552 17.75C29.4835 20.1261 27.8927 19.6796 25.8175 16.1667C24.7884 14.425 23.5259 13 23.0108 13C22.4957 13 21.2332 14.425 20.2041 16.1667ZM12.4552 29.8889C12.4552 31.8596 13.1593 32 23.0108 32C32.8623 32 33.5664 31.8596 33.5664 29.8889C33.5664 27.9182 32.8623 27.7778 23.0108 27.7778C13.1593 27.7778 12.4552 27.9182 12.4552 29.8889Z"
                :fill="color"
                fill-opacity="0.7"
            />
        </g>
        <defs>
            <filter
                id="filter0_f_382_1216"
                x="-16.6364"
                y="-14.6364"
                width="78.8947"
                height="74.2727"
                filterUnits="userSpaceOnUse"
                color-interpolation-filters="sRGB"
            >
                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape" />
                <feGaussianBlur stdDeviation="13.8182" result="effect1_foregroundBlur_382_1216" />
            </filter>
        </defs>
    </svg>
</template>
