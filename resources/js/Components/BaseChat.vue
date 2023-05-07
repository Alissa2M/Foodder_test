<script setup>
import BaseChatBackground from './BaseChatBackground.vue';

const porps = defineProps({
    chatsResponse:Array,
})
</script>

<template>
    <div v-for="(chat,index) in chatsResponse">
        <!-- ユーザー欄 -->
        <div v-if="index === 0 || index === 2 || index === 4">
            <BaseChatBackground :show-triangle="false" :user-box="true">
                <div style="white-space:pre-line;" class="chat_text">{{ chat }}</div>
            </BaseChatBackground>
        </div>
        <!-- 出力欄 -->
        <div v-else class="foonya_box">
            <div class="foonya"></div>
            <BaseChatBackground>
                <div style="white-space:pre-line;" class="chat_text">{{ chat }}</div>
            </BaseChatBackground>

        </div>
    </div>
</template>

<style scoped>
.foonya_box{
    display: flex;
}
.foonya{
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    margin: 5px 10px 0 0;
    border-radius: 100%;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.123);
    background-image: url(../../../public/img/Foonya_icon.webp);
    background-size: cover;
}
.chat_text{
    word-wrap: break-word;
}
</style>