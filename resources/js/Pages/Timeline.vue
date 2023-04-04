<script setup>
import { Head } from '@inertiajs/vue3';
import TheFooter from '@/Components/TheFooter.vue';
import ResponsiveHeader from '@/Components/ResponsiveHeader.vue';
import TimelinePost from '@/Components/TimelinePost.vue';

const props = defineProps({
    calenders:Array,
});

// ヘッダー
const clickFoodder = () => {
    location.href='/';
}
</script>

<template>
    <Head title="タイムライン" />
    <!-- ヘッダー -->
    <div class="header">
        <img src="../../../public/img/Foodder_logo.webp" alt="トップ画面へ" class="foodder_logo" @click="clickFoodder">
    </div>
    <ResponsiveHeader :on-timeline="true"/>
    <main>
        <div class="responsive">
            <TimelinePost v-bind:calenders-array="props.calenders"/>
        </div>
    </main>
    <TheFooter :href="route('dashboard')" :timeline-page="true">
        <i class="fa-solid fa-plus to_post"></i>
    </TheFooter>
</template>

<style scoped>
/* ヘッダー */
.header{
    display: flex;
    flex-direction: row;
    width: 90%;
    margin: 10px auto;
}
.foodder_logo{
    height: 25px;
}

main{
    margin-bottom: 100px;
}
/* フッダー */
.to_post{
    color: #fff;
    font-size: 23px;
}

/* レスポンシブ */
@media screen and (min-width:1024px) {
/*　画面サイズが1024pxからはここを読み込む　*/
    .header{
       display: none;
    }    
    main{
        width: 1024px;
        margin: 20px auto;
    }
    .responsive{
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
    }
}

</style>