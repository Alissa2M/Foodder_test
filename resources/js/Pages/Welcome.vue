<script setup>
import { ref, reactive } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import BaseModal from '@/Components/BaseModal.vue';
import BasePost from '@/Components/BasePost.vue';

const props = defineProps({
    calenders : Array,
    events : Array,
    posts: Array,
    result: String,
});

const showPostInfo = ref();

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
});

const submit = (e) => {
    form.post(route('post'),e);

}

const closeModal = () => {
    showPost.value = false;
    if(props.result){
        location.reload();
    }
}

const showPost = ref(false);

const postClick = (e) => {
    showPost.value = true;
    showPostInfo.value = e;
}

const deletePost = () => {
    form.post(route('delete'),{
        onSuccess: () => closeModal(),
    });
}

const clickDelete = (e) => {
    form.calenderId = e;
    deletePost()
}
</script>

<template>
    <Head title="カレンダー" />
    <main>
        <!-- カレンダー -->
        <div class="calender_box" :class="{'position_relative':showPost}">
            <form @submit.prevent="submit">
                <FullCalendar 
                    :options="calendarOptions"
                    class="fullcalendar"
                />
                <input type="hidden" name="date" value="form.date">
            </form>
        </div>
        <div class="nav">
            <img src="../../../public/img/Foodder_logo.png" alt="" class="foodder_logo">
            <Link href="/profile" class="to_profile">
                <i class="fa-solid fa-circle-user"></i>
            </Link>
        </div>
        <!-- 投稿 -->
        <div class="input_confirm" v-for="(value, key) in props.calenders" :key="key" @click="postClick(value.id)">
            <div class="photo_box">
                <img :src="value.img_path" alt="" class="photo_review" v-if="value.img_path">
            </div>
            <div class="preview_content" >
                <BasePost v-bind:three-point="true" v-bind:title="value.title" v-bind:description="value.description" v-bind:start="value.start"/>
            </div>
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
        <form @submit.prevent="deletePost">
            <template v-for="(value, key) in props.posts" :key="key">
                <div v-if="String(value.id) === String(showPostInfo)">
                    <span class="delete_btn" @click="clickDelete(value.id)">削除<i class="fa-solid fa-trash-can ml-1"></i></span>
                    <img :src="value.img_path" class="modal_image">
                    <BasePost v-bind:three-point="false" v-bind:title="value.title" v-bind:description="value.description" v-bind:start="value.start" v-bind:modal="true" class="modal_text"/>
                </div>
            </template>
        </form>
    </BaseModal>
</template>
<style scoped>
main{
    margin-bottom: 100px;
}
.calender_box{
    padding: 18px;
    background-color: #fff;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);
    z-index: -1;
}
.position_relative{
    position: relative;
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
.input_confirm{
    display: flex;
    flex-direction: row;
    width: 90vw;
    height: 80px;
    margin: 10px auto 20px;
    background: #FFFFFF;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 15px; 
    overflow: hidden;
}
.nav{
    display: flex;
    flex-direction: row;
    width: 90vw;
    margin: 10px auto;
}
.foodder_logo{
    display: inline-block;
    width: 40%;
}
.to_profile{
    display: inline-block;
    margin: auto 0 0 auto;
}
.photo_box{
    width: 80px;
    height:80px;
    background-image: url("../../../public/img/no_image.png");
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

.delete_btn{
    position: absolute;
    top: 12px;
    right: 20px;
    font-size: 10px;
    font-weight: normal;
}
.modal_image{
    max-height: 40vh;
    width: auto;
    margin: 0 auto;
    object-fit: cover;
}

</style>