<script setup>
import BasePost from '@/Components/BasePost.vue';
import BaseGoodButton from '@/Components/BaseGoodButton.vue';
import BaseModal from '@/Components/BaseModal.vue';
import BaseEdit from '@/Components/BaseEdit.vue';
import { usePage,useForm} from '@inertiajs/vue3';
import { ref } from 'vue';


const props = defineProps({
    calendersArray:Array,
    likedPost:{
        type:Boolean,
        default:false
    }
})

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

// ユーザー判別
const user = usePage().props.auth.user;

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
    selectPost.value = props.calendersArray.find(post => post.id === showPostInfo.value);
}

const closeEditModal = () => {
    editModal.value = false;
    selectPost.value = '';
}

// 共有するボタン
const shareLink = ref();
const shareModal = ref(false);
const generateShareLink = (id, title) => {
    let encoded = encodeURIComponent(id + title);
    if (encoded.length > 15) {
        encoded = encoded.substr(0, 15);
    }
    shareLink.value = window.location.origin + '/timeline#' + encoded;
    shareModal.value = true;
}

const closeShareModal = () => {
    shareModal.value = false;
}

const shareId = (id, title) => {
    let encoded = encodeURIComponent(id + title)
    return encoded.length > 15 ? encoded.substr(0, 15) : encoded
}

// コピーする
const copiedAlert = ref(false);
const copyToClipboard = () => {
    navigator.clipboard.writeText(shareLink.value);
    copiedAlert.value = true;
    setTimeout(() => {
        copiedAlert.value = false;
    }, 1600)
}
</script>

<template>
    <div v-for="(value, key) in props.calendersArray" class="posts_box">
        <div class="top_box">
            <!-- 店舗名 -->
            <div class="shop_box">
                <i class="fa-solid fa-location-dot shop_icon" v-if="value.shop_name"></i>
                <span class="shop_name three_point">{{value.shop_name }}</span>
            </div>
            <!-- 共有する -->
            <i class="fa-solid fa-share-nodes share_icon" @click="generateShareLink(value.id, value.title)"></i>
        </div>
        <!-- 投稿内容 -->
        <div class="img_box" v-if="value.img_path" @click="clickImage(value.img_path)">
            <img :src="value.img_path" class="food_img" >
        </div>
        <BasePost :three-point="false" :title="value.title" :description="value.description" :start="value.created_at" />
        <div class="post_nav" :id="shareId(value.id,value.title)">
            <div v-if="user">
                <button v-if="user.id === value.user.id" type="button" @click="clickEdit(value.id)"><i class="fa-solid fa-pen icon"></i></button>
                <button v-if="user.id === value.user.id" type="button" @click="clickDelete(value.id)"><i class="fa-solid fa-trash-can icon"></i></button>
            </div>
            <BaseGoodButton :calender-id="value.id" :like-number="value.likes_count" :like-check="value.liked_by_user" :user-check="user" class="ml-auto"/>
        </div>
    </div>
    <BaseModal v-bind:show="showPost" v-bind:show-title="false" v-on:close="closeModal">
        <img :src="photoUrl" alt="モーダル写真" class="modal_image">
    </BaseModal>
    <BaseModal v-bind:show="editModal" v-bind:show-title="false" v-on:close="closeEditModal" v-if="selectPost">
        <BaseEdit :edit-post="selectPost" :calender-id="showPostInfo"></BaseEdit>
    </BaseModal>
    <BaseModal v-bind:show="shareModal" v-bind:show-title="true" modal-title="共有する" v-on:close="closeShareModal">
        <div class="share_box">
            <span class="share_link">{{ shareLink }}</span>
            <i class="fa-regular fa-clone copy_button" :class="{'copied_button':copiedAlert}" @click="copyToClipboard"></i>
            <span class="copied" v-show="copiedAlert">copied</span>
        </div>
    </BaseModal>

</template>

<style scoped>
/* 投稿 */
.posts_box{
    display: flex;
    flex-direction: column;
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
    align-items: center;
    font-size: 12px;
    margin-bottom: 3px;
}
.shop_box{
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    overflow: hidden;
    width: 70%;
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
.share_icon{
    color: #FF6F00;
    padding: 0 5px;
    cursor: pointer;
}
::v-deep .ate_day{
    display: none;
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
    height: 100%;
    width: 100%;
    object-fit: cover;
}
.post_nav{
    display: flex;
    flex-direction: row;
    margin-top: auto;

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
.share_box{
    position: relative;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}
.share_link{
    width: 90%;
    word-wrap: break-word;
    text-align: left;
}
.copied{
    position: absolute;
    bottom: -15px;
    right: -8px;
    color: #FF6F00;
}
.copy_button{
    color: #FF6F00;
    border: 1px solid #FF6F00;
    border-radius: 100%;
    padding: 6px;
    cursor: pointer;
}
.copied_button{
    color: #fff;
    font-weight: bold;
    background-color: #FF6F00;
}
/* レスポンシブ */
@media screen and (min-width:1024px) {
/*　画面サイズが1024pxからはここを読み込む　*/
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