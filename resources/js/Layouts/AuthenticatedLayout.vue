<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps(['href']);
const emit = defineEmits(['clickButton']);

const onClick = () => {
    emit('clickButton')
}
</script>

<template>
    <div class="contents">
        <header>
            <a href="javascript:history.go(-1)" class="back_page">戻る</a>
            <slot name="header" />
        </header>
        <main>
            <slot name="main"/>
        </main>
        <footer>
            <Link :href="href" class="circle_button" @click="onClick">
                <div class="mark_position">
                    <slot name="footer"/>
                </div>
            </Link>
        </footer>
    </div>
</template>

<style scoped>
header{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin: 10px;
}
.back_page{
    font-size: 14px;
    padding-left: 18px;
    margin: auto 0;
    background-image: url("../../../public/img/back.png");
    background-repeat: no-repeat;
    background-position: 0 50%;
    background-size: 13px;
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