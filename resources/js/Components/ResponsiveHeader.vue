<script setup>
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    onCalender:{
        type:Boolean,
        default:false
    },
    onTimeline:{
        type:Boolean,
        default:false
    },
    onChat:{
        type:Boolean,
        default:false
    },
    onProfile:{
        type:Boolean,
        default:false
    },
})

const user = usePage().props.auth.user;

</script>

<template>
    <header>
        <!-- アイコン -->
        <img src="../../../public/img/Foodder_logo.webp" alt="Foodder" class="logo">
        <!-- メニュー -->
        <div class="nav_bar">
            <a href="/" class="link_button" :class="{'link_clicked':onCalender}"><i class="fa-regular fa-calendar"></i>カレンダー</a>
            <a href="/timeline" class="link_button" :class="{'link_clicked':onTimeline}"><i class="fa-regular fa-clock"></i>タイムライン</a>
            <a href="/chat" class="link_button" :class="{'link_clicked':onChat}"><i class="fa-regular fa-comment-dots"></i>AIチャット</a>
            <a href="/profile" class="link_button" :class="{'link_clicked':onProfile}" v-show="user"><i class="fa-regular fa-user"></i>プロフィール</a>
            <!-- 投稿するボタン -->
            <a href="/dashboard" class="link_button important" v-show="user"><i class="fa-solid fa-plus"></i>投稿</a>
            <!-- ログインボタン -->
            <a href="/login" class="link_button important" v-show="!user">ログイン</a>
        </div>
        
    </header>
</template>

<style scoped>
header{
    display: none;
}
/* レスポンシブ */
@media screen and (min-width:1024px) {
/*　画面サイズが1024pxからはここを読み込む　*/
    header{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        width: 100%;
        background-color: #FFC107;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);
    }
    .logo{
        height: 40px;
        margin: 10px ;
    }
    .nav_bar{
        display: flex;
        flex-direction: row;
        gap: 20px;
        font-size: 16px;
        margin: auto 20px;
    }
    .link_button{
        padding: 5px 10px;
        border-radius: 5px;
        box-shadow: 0px 2px 5px 1px rgba(0, 0, 0, 0.08);
    }
    .link_clicked{
        box-shadow: inset 0px 1px 5px rgba(0, 0, 0, 0.25);
        background-color: #f7b900;
    }
    i{
        margin-right: 3px;
    }
    .important{
        color: #fff;
        font-weight: bold;
        background-color:#FF6F00;
        border-radius: 20px;
        padding: 5px 15px;
    }
}   
</style>