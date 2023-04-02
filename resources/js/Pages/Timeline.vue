<script setup>
import { ref } from 'vue';
import BaseModal from '@/Components/BaseModal.vue';
import BasePost from '@/Components/BasePost.vue';
import BaseGoodButton from '@/Components/BaseGoodButton.vue';
import { Head, usePage, useForm } from '@inertiajs/vue3';
import TheFooter from '@/Components/TheFooter.vue';
import BaseEdit from '@/Components/BaseEdit.vue';
import ResponsiveHeader from '@/Components/ResponsiveHeader.vue';

const props = defineProps({
    calenders:Array,
});

// ヘッダー
const clickFoodder = () => {
    location.href='/';
}

// モーダル
const photoUrl = ref('');
const showPost = ref(false);

const clickImage = (e) => {
    showPost.value = true;
    photoUrl.value = e;
}

const closeModal = () => {
    showPost.value = false;
}

const form = useForm({
    calenderId:''
});

// ユーザーネームをクリックしてプロフィール画面に遷移
const user = usePage().props.auth.user;
const clickUser = (e) => {
    if(user){
        if(user.id === e){
            location.href='/profile'
        }else{
            location.href="/guestProfile/id="+e;
        }
    }else{
        location.href="/guestProfile/id="+e;
    }
}

// 削除ボタン
const clickDelete = (e) => {
    form.calenderId = e;
    form.delete(route('delete'));
}

// 編集のボタン
const editModal = ref(false);
const selectPost = ref('');
const showPostInfo = ref();
const clickEdit = (e) => {
    showPostInfo.value = e;
    editModal.value = true;
    selectPost.value = props.calenders.find(post => post.id === showPostInfo.value)
}

const closeEditModal = () => {
    editModal.value = false;
}


</script>

<template>
    <Head title="タイムライン" />
    <!-- ヘッダー -->
    <div class="header">
        <img src="../../../public/img/Foodder_logo.webp" alt="トップ画面へ" class="foodder_logo" @click="clickFoodder">
    </div>
    <ResponsiveHeader on-timeline="true" />
    <main>
        <div class="responsive">
            <div v-for="(value, key) in props.calenders" class="posts_box">
                <div class="top_box">
                    <!-- 匿名ユーザー -->
                    <div class="user_info" v-if="value.anonymous">
                        <img src="../../../public/img/guest.webp" alt="ユーザーアイコン" class="user_icon">
                        <span>匿名ユーザー</span>
                    </div>
                    <!-- 一般ユーザー -->
                    <div class="user_info" v-else @click="clickUser(value.user.id)">
                        <img :src="value.user.user_icon" alt="ユーザーアイコン" class="user_icon" v-if="value.user.user_icon">
                        <img src="../../../public/img/guest.webp" alt="ユーザーアイコン" class="user_icon" v-else>
                        <span>{{ value.user.name }}</span>
                    </div>
                    <!-- 店舗名 -->
                    <div class="shop_box">
                        <i class="fa-solid fa-location-dot shop_icon" v-if="value.shop_name"></i>
                        <span class="shop_name three_point">{{value.shop_name }}</span>
                    </div>
                </div>
                <!-- 投稿内容 -->
                <div class="img_box" v-if="value.img_path" @click="clickImage(value.img_path)">
                    <img :src="value.img_path" class="food_img" >
                </div>
                <BasePost :three-point="false" :title="value.title" :description="value.description" :start="value.created_at" />
                <div class="post_nav">
                    <button v-if="user.id === value.user.id" type="button" @click="clickEdit(value.id)"><i class="fa-solid fa-pen icon"></i></button>
                    <button v-if="user.id === value.user.id" type="button" @click="clickDelete(value.id)"><i class="fa-solid fa-trash-can icon"></i></button>
                    <BaseGoodButton :calender-id="value.id" :like-number="value.likes_count" :like-check="value.liked_by_user" :user-check="user" class="ml-auto"/>
                </div>
            </div>
        </div>
    </main>
    <TheFooter :href="route('dashboard')" :timeline-page="true">
        <i class="fa-solid fa-plus to_post"></i>
    </TheFooter>
    <BaseModal v-bind:show="showPost" v-bind:show-title="false" v-on:close="closeModal">
        <img :src="photoUrl" alt="モーダル写真" class="modal_image">
    </BaseModal>
    <BaseModal v-bind:show="editModal" v-bind:show-title="false" v-on:close="closeEditModal" v-if="selectPost">
        <BaseEdit :edit-post="selectPost" :calender-id="showPostInfo"></BaseEdit>
    </BaseModal>

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
/* 投稿 */
.posts_box{
    width: 90%;
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
    justify-content: flex-end;
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
    width: 25px;
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
.post_nav{
    display: flex;
    flex-direction: row;
}
.icon{
    width: 22px;
    height: 22px;
    color: #FF6F00;
    font-size: 10px;
    padding: 5px;
    margin: 0 2px;
    border: 1px solid #FF6F00;
    border-radius: 100%
}
/* モーダル */
.modal_image{
    max-height: 40vh;
    width: auto;
    margin: 0 auto;
    object-fit: cover;
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
    .posts_box{
        width: 48%;
    }
    .img_box{
        height: 30vh;
    }
    .food_img{
        height:100%;
    }
}

</style>