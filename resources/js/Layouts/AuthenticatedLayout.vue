<script setup>
import TheFooter from '@/Components/TheFooter.vue';
import TheHeader from '@/Components/TheHeader.vue';

const props = defineProps({
    href:String,
    displayCurcle:{
        type:Boolean,
        default:true
    },
    displayFooter:Boolean,
    profilePage:{
        type:Boolean,
        default:false
    },
    chatPage:{
        type:Boolean,
        default:false
    },
});
const emit = defineEmits(['clickButton']);

const onClick = () => {
    emit('clickButton')
}
</script>

<template>
    <div class="contents">
        <TheHeader />
        <main>
            <slot name="main"/>
        </main>
        <TheFooter :href="href" @click="onClick" :display-curcle="props.displayCurcle" :display-footer="props.displayFooter" :profile-page="props.profilePage" :chat-page="props.chatPage">
            <slot name="footer"/>
        </TheFooter>
    </div>
</template>

<style scoped>
main{
    margin-bottom: 100px;
}
/* レスポンシブ */
@media screen and (min-width:1024px) {
/*　画面サイズが1024pxからはここを読み込む　*/
    main{
        width: 1024px;
        margin: 20px auto;
    }
}</style>