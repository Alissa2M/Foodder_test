<script setup>
import BasePost from '@/Components/BasePost.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    calenders:Array,
});

</script>

<template>
    <header></header>
    <main>
        <div v-for="(value, key) in props.calenders" class="posts_box">
            <!-- 匿名ユーザー -->
            <div class="user_info" v-if="!value.user">
                <img src="../../../public/img/guest.png" alt="ユーザーアイコン" class="user_icon">
                <span>匿名ユーザー</span>
            </div>
            <!-- 一般ユーザー -->
            <div class="user_info" v-if="value.user">
                <img src="../../../public/img/guest.png" alt="ユーザーアイコン" class="user_icon">
                <span>{{ value.user.name }}</span>
            </div>
            <img :src="value.img_path" class="food_img" v-if="value.img_path">
            <BasePost :three-point="false" :title="value.title" :description="value.description" :start="value.created_at"/>
        </div>
    </main>
    <footer>
        <Link :href="route('dashboard')" class="circle_button">
            <div class="mark_position">
                <img src="../../../public/img/plus.png" alt="投稿する">
            </div>
        </Link>
    </footer>
</template>

<style scoped>
header{
    height: 4vh;
    width: 90vw;
    margin: 10px auto;
    background-image: url("../../../public/img/Foodder_logo.png");
    background-repeat: no-repeat;
    background-size: contain;
}
main{
    margin-bottom: 100px;
}
.posts_box{
    width: 90vw;
    margin: 15px auto;
    padding: 10px;
    background-color: #fff;
    box-shadow: 0px 4px 4px rgb(0 0 0 / 25%);
    border-radius: 0.5rem;
}
::v-deep .ate_day{
    display: none;
}
.user_info{
    display: flex;
    flex-direction: row;
    align-items: center;
    font-size: 12px;
    margin-bottom: 5px;
}
.user_icon{
    height: 25px;
    width: auto;
    background-color: #fff;
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25);
    border-radius: 100%;
    object-fit: cover;
    margin-right: 5px;
}
.food_img{
    margin: 8px 0;
    border: 1px solid #c9c9c9;
}
footer{
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 60px;
    background-color: #FFC107;
    box-shadow: 0px -2px 4px rgba(0, 0, 0, 0.25);
}
.circle_button{
    position: absolute;
    top: -25px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50px;
    height: 50px;
    margin: 0 auto;
    background-color: #FF6F00;
    border-radius: 100px;
    box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.25);
}
.mark_position{
    width: 1.3rem;
}
</style>