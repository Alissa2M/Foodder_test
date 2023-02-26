<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

const calendarOptions = ref({
    plugins: [ dayGridPlugin, interactionPlugin ],
    initialView: 'dayGridMonth',
    // locale: 'ja',
    height: "60vh",
    headerToolbar: {
        right: 'prev,next',
        left: 'title'
    },
    // contentHeight:"auto"
})     

</script>

<template>
    <Head title="カレンダー" />
    <main>
        <!-- カレンダー -->
        <div class="calender_box">
            <FullCalendar 
                :options="calendarOptions" 
                class="fullcalendar"
            />
        </div>
        <!-- 投稿 -->
        <div>

        </div>
    </main>
    <footer>
        <Link href="/dashboard" class="circle_button">
            <div class="mark_position">
                <img src="../../../public/img/plus.png" alt="投稿する">
            </div>
        </Link>
    </footer>

</template>

<style scoped>

.calender_box{
    padding: 10px 18px 18px;
    background-color: #fff;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);
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