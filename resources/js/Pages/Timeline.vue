<script setup>
import { ref } from 'vue';
import BaseModal from '@/Components/BaseModal.vue';
import BasePost from '@/Components/BasePost.vue';
import { Head, Link } from '@inertiajs/vue3';
import TheFooter from '@/Components/TheFooter.vue';

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
            <div class="top_box">
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
                <div class="shop_box">
                    <i class="fa-solid fa-location-dot shop_icon" v-if="value.shop_name"></i>
                    <span class="shop_name three_point">{{value.shop_name }}</span>
                </div>
            </div>
            <div class="img_box" v-if="value.img_path" @click="clickImage(value.img_path)">
                <img :src="value.img_path" class="food_img" >
            </div>
            <BasePost :three-point="false" :title="value.title" :description="value.description" :start="value.created_at" />
        </div>
    </main>
    <TheFooter :href="route('dashboard')" :timeline-page="true">
        <img src="../../../public/img/plus.png" alt="投稿する">
    </TheFooter>
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
.top_box{
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: space-between;
    font-size: 12px;
}
.shop_box{
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: end;
    overflow: hidden;
    width: 50%;
}
.shop_icon{
    color: #FF6F00;
    margin: auto 3px 3px 0;
}
.shop_name{
    white-space: nowrap;
    margin-top: auto;
}
.three_point{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
::v-deep .ate_day{
    display: none;
}
.user_info{
    display: flex;
    flex-direction: row;
    align-items: center;
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
    margin: 0 0 8px;
    background-color: #c9c9c9;
    border: 1px solid #c9c9c9;
    overflow: hidden;
}
.food_img{
    height: 50vw;
    width: 100%;
    object-fit: cover;
}
.modal_image{
    max-height: 40vh;
    width: auto;
    margin: 0 auto;
    object-fit: cover;
}
</style>