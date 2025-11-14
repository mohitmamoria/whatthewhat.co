<script setup>
import Linktree from '@/components/Linktree.vue';
import PageHeading from '@/components/PageHeading.vue';
import Narrow from '@/layouts/Narrow.vue';

const props = defineProps({
    links: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <Narrow>
        <PageHeading>
            Hello, it's us, the authors!
            <template #description> Here's you can find us everywhere on the internet. Come say hello! </template>
        </PageHeading>
        <Linktree :links="links" />
    </Narrow>
</template>
