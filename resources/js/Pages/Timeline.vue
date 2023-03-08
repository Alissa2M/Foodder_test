<script setup>
import { ref } from 'vue';
import BaseModal from '@/Components/BaseModal.vue';
import BasePost from '@/Components/BasePost.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    calenders:Array,
});

const clickFoodder = () => {
    location.href='/';
}

const photoUrl = ref('');
const showPost = ref(false);

const clickImage = (e) => {
    showPost.value = true;
    photoUrl.value = e;
}

const closeModal = () => {
    showPost.value = false;
}

</script>

<template>
    <Head title="タイムライン" />
    <header>
        <img src="../../../public/img/Foodder_logo.png" alt="トップ画面へ" class="foodder_logo" @click="clickFoodder">
    </header>
    <main>
        <div v-for="(value, key) in props.calenders" class="posts_box">
            <!-- 匿名ユーザー -->
            <div class="user_info" v-if="value.anonymous">
                <img src="../../../public/img/guest.png" alt="ユーザーアイコン" class="user_icon">
                <span>匿名ユーザー</span>
            </div>
            <!-- 一般ユーザー -->
            <div class="user_info" v-else>
                <img src="../../../public/img/guest.png" alt="ユーザーアイコン" class="user_icon">
                <span>{{ value.user.name }}</span>
            </div>
            <div class="img_box" v-if="value.img_path" @click="clickImage(value.img_path)">
                <img :src="value.img_path" class="food_img" >
            </div>
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
    <BaseModal v-bind:show="showPost" v-bind:show-title="false" v-on:close="closeModal">
        <img :src="photoUrl" alt="モーダル写真" class="modal_image">
    </BaseModal>
</template>

<style scoped>
header{
    width: 90vw;
    margin: 10px auto;
}
.foodder_logo{
    height: 4vh;
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
.img_box{
    position: relative;
    width: 100%;
    height: 50vw;
    margin: 8px 0;
    background-color: #c9c9c9;
    border: 1px solid #c9c9c9;
    overflow: hidden;
}
.food_img{
    height: 50vw;
    width: 100%;
    object-fit: cover;
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

.modal_image{
    max-height: 40vh;
    width: auto;
    margin: 0 auto;
    object-fit: cover;
}
</style>