<script setup>
import TheFooter from '@/Components/TheFooter.vue';
import TheHeader from '@/Components/TheHeader.vue';

const props = defineProps(['href']);
const emit = defineEmits(['clickButton']);

const onClick = () => {
    emit('clickButton')
}
</script>

<template>
    <div class="contents">
        <TheHeader />
        <main>
            <slot name="main"/>
        </main>
        <TheFooter :href="href" @click="onClick">
            <slot name="footer"/>
        </TheFooter>
    </div>
</template>
