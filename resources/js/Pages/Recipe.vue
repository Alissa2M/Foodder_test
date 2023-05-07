<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ResponsiveHeader from '@/Components/ResponsiveHeader.vue';
import BaseRecipe from '@/Components/BaseRecipe.vue';

defineProps({
    recipe:Object,
});

</script>

<template>
    <Head title="レシピ" />
    <ResponsiveHeader :on-profile="true"/>
    <AuthenticatedLayout v-bind:href="'/dashboard'">
        <template #main>
            <!-- コンポーネント用意 -->
            <BaseRecipe :recipe-detail="recipe" :is-readonly="true" :show-count="false"/>
        </template>
        <template #footer>
            <i class="fa-solid fa-plus to_post"></i>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>
/* フッダー */
.to_post{
    color: #fff;
    font-size: 23px;
}

</style>