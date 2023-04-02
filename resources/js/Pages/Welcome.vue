<script setup>
import { ref, reactive } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import BaseModal from '@/Components/BaseModal.vue';
import BasePost from '@/Components/BasePost.vue';
import TheFooter from '@/Components/TheFooter.vue';
import BaseEdit from '@/Components/BaseEdit.vue';
import ResponsiveHeader from '@/Components/ResponsiveHeader.vue';

const props = defineProps({
    calenders : Array,
    events : Array,
    posts: Array,
    result: String,
});

// カレンダー設定
const calendarOptions = reactive({
    plugins: [ dayGridPlugin, interactionPlugin ],
    initialView: 'dayGridMonth',
    height: "60vh",
    events: props.events,
    dayMaxEvents:true,
    headerToolbar: {
        right: 'prev,next',
        left: 'title'
    },
    // 日付マスのクリックイベント
    dateClick: (e)=>{
		form.date = e.dateStr;
        submit(form.date)
	},
    // イベントのクリックイベント
    eventClick: (info)=>{
        showPost.value = true;
        showPostInfo.value = info.event.id;
    }
})

const form = useForm({
    date: '',
    calenderId: '',
    title:'',
    memo: '',
    shop_name: '',
    img_path: '',
    category:'',
    anonymous:''
});

// カレンダーIDと日付を送信
const submit = (e) => {
    form.post(route('post'),e);
}

// モーダル表示
const showPostInfo = ref();
const showPost = ref(false);
const postClick = (e) => {
    showPost.value = true;
    showPostInfo.value = e;
}

// モーダル閉じる
const closeModal = () => {
    showPost.value = false;
    if(props.result){
        location.reload();
    }
}

// 投稿を削除
const deletePost = () => {
    form.delete(route('delete'),{
        onSuccess: () => closeModal(),
    });
}

const clickDelete = (e) => {
    form.calenderId = e;
    deletePost()
}

// 投稿を編集
const editModal = ref(false);
const selectPost = ref('');
const clickEdit = (e) => {
    showPostInfo.value = e;
    editModal.value = true;
    selectPost.value = props.posts.find(post => post.id === showPostInfo.value);
}

const closeEditModal = () => {
    editModal.value = false;
    selectPost.value = '';
}


</script>

<template>
    <Head title="カレンダー" />
    <ResponsiveHeader :on-calender="true"/>
    <main>
        <!-- カレンダー -->
        <div class="calender_box" :class="{'relative':showPost}">
            <form @submit.prevent="submit">
                <FullCalendar 
                    :options="calendarOptions"
                    class="fullcalendar"
                />
                <input type="hidden" name="date" value="form.date">
            </form>
        </div>
        <!-- foodderロゴ -->
        <div class="nav">
            <img src="../../../public/img/Foodder_logo.webp" alt="Foodder" class="foodder_logo">
        </div>
        <!-- 投稿 -->
        <div class="input_confirm" v-for="(value, key) in props.calenders" :key="key" @click="postClick(value.id)">
            <div :class="{'photo_box':!value.img_path}">
                <img :src="value.img_path" alt="投稿画像" class="photo_review" v-if="value.img_path">
            </div>
            <div class="preview_content" >
                <BasePost v-bind:three-point="true" v-bind:title="value.title" v-bind:description="value.description" v-bind:start="value.start" :shop-name="value.shop_name"/>
            </div>
        </div>
    </main>
    <TheFooter :href="route('dashboard')" :calender-page="true">
        <i class="fa-solid fa-plus to_post"></i>
    </TheFooter>
    <BaseModal v-bind:show="showPost" v-bind:show-title="false" v-on:close="closeModal">
        <form @submit.prevent="deletePost">
            <template v-for="(value, key) in props.posts" :key="key">
                <div v-if="String(value.id) === String(showPostInfo)">
                    <div class="icon_box">
                        <button type="button" @click="clickDelete(value.id)"><i class="fa-solid fa-trash-can icon"></i></button>
                        <button type="button" @click="clickEdit(value.id)"><i class="fa-solid fa-pen icon"></i></button>
                    </div>
                    <img :src="value.img_path" class="modal_image">
                    <BasePost v-bind:three-point="false" v-bind:title="value.title" v-bind:description="value.description" v-bind:start="value.start" v-bind:modal="true" :shop-name="value.shop_name"/>
                </div>
            </template>
        </form>
    </BaseModal>
    <BaseModal v-bind:show="editModal" v-bind:show-title="false" v-on:close="closeEditModal" v-if="selectPost">
        <BaseEdit :edit-post="selectPost" :calender-id="showPostInfo"></BaseEdit>
    </BaseModal>
</template>
<style scoped>
main{
    margin-bottom: 100px;
}
/* カレンダー */
.calender_box{
    padding: 18px;
    background-color: #fff;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);
    z-index: -1;
}
::v-deep .fc .fc-toolbar-title{
    font-size: 20px;
}
::v-deep .fc .fc-toolbar.fc-header-toolbar{
    margin-bottom: 5px;
}
::v-deep .fc .fc-button{
    padding: 0 10px;
    background-color: #FFC107;
    border: #FFC107;
}
::v-deep .fc .fc-button-primary:focus {
    box-shadow: none;
    background-color: #FFC107;
}
::v-deep .fc .fc-button-primary:not(:disabled):active{
    box-shadow: none;
    background-color:#FFC107 ;
}
::v-deep .fc .fc-button-primary:not(:disabled):active:focus{
    box-shadow: none;
    background-color:#FFC107 ;
}
::v-deep .fc .fc-button-primary:hover{
    background-color: #FFC107;
}
::v-deep .fc .fc-button .fc-icon{
    font-size: 1rem;
    vertical-align:baseline;
}
::v-deep .fc .fc-scroller-harness{
    font-size: 12px;
}
::v-deep .fc th .fc-scrollgrid-sync-inner{
    color: #fff;
    background-color: #FF6F00;
}
::v-deep .fc .fc-daygrid-day-number{
    padding: 2px;
}
::v-deep .fc .fc-daygrid-body-natural .fc-daygrid-day-events{
    margin-bottom: 0;
}
::v-deep .fc-event-time{
    display: none;
} 
/* foodderロゴ */
.nav{
    display: flex;
    flex-direction: row;
    width: 90%;
    margin: 10px auto;
}
.foodder_logo{
    display: inline-block;
    height: 25px;
}

/* 投稿 */
.input_confirm{
    display: flex;
    flex-direction: row;
    width: 90%;
    height: 80px;
    margin: 10px auto 20px;
    background: #FFFFFF;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 15px; 
    overflow: hidden;
}
.photo_box{
    width: 80px;
    height:80px;
    background-image: url("../../../public/img/no_image.webp");
    background-size: contain;
    background-position: 50% 50%;
    background-repeat: no-repeat;
    background-color: #D9D9D9;
    flex-shrink: 0;
}
.photo_review{
    width: 80px;
    height: 80px;
    object-fit:cover;
    object-position: 50% 50%;
    flex-shrink: 0;
}

.preview_content{
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    padding: 5px 10px;
    overflow-y: hidden;
}

/* モーダル */
.modal_image{
    max-height: 40vh;
    width: auto;
    margin: 0 auto;
    object-fit: cover;
}
.icon_box{
    position: absolute;
    top: 6px;
    right: 2px;
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

/* フッダー */
.to_post{
    color: #fff;
    font-size: 23px;
}

/* レスポンシブ */
@media screen and (min-width:1024px) {
/*　画面サイズが1024pxからはここを読み込む　*/
    main{
        width: 1024px;
        margin: 20px auto;
    }
}

</style>