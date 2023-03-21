<script setup>
import { ref } from 'vue';
import TheFooter from '@/Components/TheFooter.vue'
import TheHeader from '@/Components/TheHeader.vue';
import { Head,Link } from '@inertiajs/vue3';

const props = defineProps({
    users: Array,
})

const userHeader = ref(props.users[0].user_header);
const userIcon = ref(props.users[0].user_icon);
</script>

<template>
    <Head title="プロフィール" />
        <TheHeader />
        <div class="foodder_logo">
            <Link href="/">
                <img src="../../../../public/img/Foodder_logo.png" alt="Foodder">
            </Link>
        </div>
        <!-- ユーザー情報 -->
        <div class="form">
            <!-- ヘッダー画像 -->
            <div>
                <img src="../../../../public/img/header.jpg" alt="header" class="header" v-if="!userHeader"/>
                <img :src="userHeader" alt="ヘッダー" class="header" v-else>
            </div>
            <div class="icon_box">
                <div class="position_box">
                    <!-- アイコン -->
                    <div>
                        <img src="../../../../public/img/guest.png" alt="icon" class="icon" v-if="!userIcon"/>
                        <img :src="userIcon" alt="アイコン" class="icon" v-else>
                    </div>
                    <!-- ユーザーネーム -->
                    <div class="dummy_box">
                        <span class="username_dummy">{{ users[0].name }}</span>
                    </div>
                </div>
            </div>
        </div>
        <TheFooter :href="route('dashboard')">
            <img src="../../../../public/img/plus.png" alt="投稿する">
        </TheFooter>
</template>

<style scoped>
/* ヘッダー */
.foodder_logo{
    width: 13rem;
    margin: 30px auto;
}
/* ユーザー情報 */
.form{
    width: 90%;
    margin: 0 auto;
    padding: 25px 25px 90px;
    background-color: #fff;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
}
.header{
    height: 130px;
    width: 100%;
    object-fit: cover;
    border: #908D8D solid 1px;
}
.icon_box{
    position: relative;
    top: 0;
    left: 0;
}
.position_box{
    position: absolute;
    top: -35px;
    left: 0;
    right: 0;
    text-align: center;
    pointer-events: none
}
.icon{
    height: 70px;
    width: 70px;
    background-color: #fff;
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25);
    border-radius: 100%;
    object-fit: cover;
    margin: 0 auto;
    pointer-events: fill;
}
.dummy_box{
    width: fit-content;
    margin: 8px auto;
    pointer-events: fill;
}
.username_dummy{
    width: fit-content;
    font-weight: bold;
    margin-left:5px;
    margin-right: 5px;
}

</style>