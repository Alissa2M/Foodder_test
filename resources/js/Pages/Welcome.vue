<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import BaseModal from '@/Components/BaseModal.vue';

const props = defineProps({
    calenders : Array,
    events : Array,
});

const calendarOptions = ref({
    plugins: [ dayGridPlugin, interactionPlugin ],
    initialView: 'dayGridMonth',
    height: "60vh",
    events: props.events,
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
        console.log(info.event.title)
    }
})

const form = useForm({
    date: ''
});

const submit = (e) => {
    form.post(route('post'),e);

}

const showImageBig = ref(false);
const photoUrl = ref('');

const clickImage = (e) => {
    showImageBig.value = true;
    photoUrl.value = e;
}

const closeModal = () => {
    showImageBig.value = false;
}

</script>

<template>
    <Head title="カレンダー" />
    <main>
        <!-- カレンダー -->
        <div class="calender_box">
            <form @submit.prevent="submit">
                <FullCalendar 
                    :options="calendarOptions"
                    class="fullcalendar"
                />
                <input type="hidden" name="date" value="form.date">
            </form>
        </div>
        <!-- 投稿 -->
        <div class="input_confirm" v-for="(value, key) in props.calenders" :key="key">
            <div class="photo_box">
                <img :src="value.img_path" alt="" class="photo_review" v-if="value.img_path" @click="clickImage(value.img_path)">
            </div>
            <div class="preview_content">
                <span class="food_name">{{ value.title }}</span>
                <p class="memo_review">{{ value.description }}</p>
                <span class="ate_day">{{ value.start.replace(/-/g,'/') }}</span>
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
    <BaseModal v-bind:show="showImageBig" v-bind:show-title="false" v-on:close="closeModal">
        <img :src="photoUrl" alt="フード">
    </BaseModal>
</template>

<style scoped>
main{
    margin-bottom: 100px;
}
.calender_box{
    position: relative;
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
    margin: 20px auto;
    background: #FFFFFF;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 15px; 
    overflow: hidden;

}
.photo_box{
    width: 80px;
    height:80px;
    background-image: url(../../../public/img/no_image.png);
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
    overflow-y: auto;
}
.food_name{
    font-weight: bold;
}
.memo_review{
    font-size: 14px;
}
.ate_day{
    display: block;
    text-align: end;
    font-size: 12px;
    color: #908D8D;
    margin-top: auto;
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