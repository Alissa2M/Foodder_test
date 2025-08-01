<script setup>
import { ref } from 'vue';
import {useForm, Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseChat from '@/Components/BaseChat.vue';
import BaseChatBackground from '@/Components/BaseChatBackground.vue';
import ResponsiveHeader from '@/Components/ResponsiveHeader.vue';
import BaseButton from '@/Components/BaseButton.vue';

const props = defineProps({
    // 過去の会話の配列
    chat_responses:{
        type:Array,
    },
    count:{
        type:Number,
        default:0,
    },
})

// 入力したメッセージ
const inputMessage = ref([]);
const textarea = ref(null);

const form = useForm({
    sentence: [],
});

const loadingCss = ref(false);
const showButton = ref(false);

// メッセージを送信
const clickSend = () => {
    if(props.chat_responses){
        form.sentence.push(...props.chat_responses);
        form.sentence.push(inputMessage.value);
    }else{
        form.sentence = [inputMessage.value];
    }
    loadingCss.value = true;
    showButton.value = true;
    form.post(route('chat_gpt.chat'), {
        preserveState: true,
        onSuccess: (response) => {
            form.sentence = [];
            inputMessage.value = [];
            loadingCss.value = false;
            showButton.value = false;   
        },
        onError: (error) => {
        console.log(error);
        },
    });
}

// テキストエリアの高さを自動調整する関数
const adjustHeight = () => {
    textarea.value.style.height = 'auto';
    textarea.value.style.height = textarea.value.scrollHeight + 'px';
};

// footerの表示切り替え
const displayFooter = ref(false);
const heightScreen = ref(false);
const heightCalc = ref(true);
const foucsInput = ref(false);

const focusText = () => {
    displayFooter.value = true;
    heightScreen.value = true;
    heightCalc.value = false;
    foucsInput.value = true;
}

const blurText = () => {
    displayFooter.value = false;
    heightScreen.value = false;
    heightCalc.value = true;
    foucsInput.value = false;
}

const user = usePage().props.auth.user;
const toLogin = () => {
    location.href='/login';
}

</script>

<template>
    <Head title="レシピ検索" />
    <ResponsiveHeader :on-chat="true"/>
    <AuthenticatedLayout :href="'/'" :display-curcle="false" :display-footer="displayFooter" :chat-page="true">
        <template #main>
            <div class="main" :class="{'height_screen':heightScreen,'height_calc':heightCalc}">
                <div>
                    <div class="foonya_box">
                        <div class="foonya"></div>
                        <BaseChatBackground>
                            <p>AIのふーにゃです。<br>【レシピ検索】が得意です！<br>文脈を理解できるけど…<br>1日<strong>3回</strong>で疲れます。。。</p>
                        </BaseChatBackground>
                    </div>
                    <!-- やり取り -->
                    <BaseChat v-bind:chats-response="props.chat_responses"/>
                </div>
                <!-- 入力欄 -->
                <div class="input_content" :class="{'focus_input':foucsInput}"  v-if="props.count !== 6">
                    <form @submit.prevent="submit" class="input_box">
                        <span class="hidden" :class="{'loading':loadingCss}">・・・考え中・・・</span>
                        <span class="text_length">{{inputMessage.length}}/100文字</span>
                        <textarea maxlength="100" rows="1" name="sentence" v-model="inputMessage" @input="adjustHeight" ref="textarea" class="inputText" @focus="focusText" @blur="blurText" v-bind:disabled="!user"></textarea>
                        <i class="fa-solid fa-paper-plane send_chat" :class="{'hidden':showButton}" @mousedown="clickSend" @touchstart="clickSend" v-if="user"></i>
                    </form>
                    <!-- 未ログイン -->
                    <div v-if="!user">
                        <p class="guest_message">※チャットのご利用はログインが必要です</p>
                        <BaseButton button-name="ログイン" class="login" @click="toLogin"/>
                    </div>
                </div>
            </div>
            <p v-if="props.count === 6" class="max_chat">※１日の利用制限に達しました。また明日も使ってね！</p>
        </template>
        <template #footer></template>
    </AuthenticatedLayout>
</template>

<style scoped>
.main{
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 92%;
    overflow: auto;
    margin: 0 auto;
    padding: 0 5px;
}
.height_screen{
    height: calc(100vh - 150px);
    margin-bottom: 20px;
}
.height_calc{
    height: calc(100vh - 200px);
}
.input_content{
    position: fixed;
    bottom: 60px;
    width: 90%;
    background-color: #FFF3E0;
    padding: 25px 0;
    margin-top: 15px;
    border-top: 2px dashed #FFC107;
}
.focus_input{
    position: fixed;
    bottom: 0px;
}
.input_box{
    position: relative;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 100%;
    background-color: #ffcba3;
    border-radius: 5px;
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25);
    padding: 0 5px;
}
.text_length{
    position: absolute;
    top: -20px;
    right: 0;
    font-size: 12px;
}
.inputText{
    width: 100%;
    padding: 10px 0px 10px 10px;
    border: none;
    background-color: transparent;
    overflow: hidden;
    resize: none;
}
.inputText:focus{
    border: none;
    box-shadow: none;
}

.send_chat{
    font-size: 12px;
    color: #fff;
    padding: 8px;
    background-color: #FF6F00;
    border-radius: 100%;
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25);
    margin: auto 5px auto;
    pointer-events: visible;
}
.foonya_box{
    display: flex;
}
.foonya{
    flex-shrink: 0;
    width: 40px;
    height: 40px;
    margin: 10px 10px 0 0;
    border-radius: 100%;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.123);
    background-image: url(../../../public/img/Foonya_icon.webp);
    background-size: cover;
}
.max_chat{
    font-size: 12px;
    width: 90%;
    text-align: center;
    margin: 40px auto 80px;
}
.loading{
    display: inline-block;
    position: absolute;
    top: -23px;
    left: 0;
    right: 0;
    font-size: 14px;
    text-align: center;
}

.guest_message{
    font-size: 12px;
}
.login{
    width: 100px;
    margin: 0 0 0 auto;
}
/* レスポンシブ */
@media screen and (min-width:1024px) {
/*　画面サイズが1024pxからはここを読み込む　*/
    .input_content{
        bottom: 20px;
        width: 950px;
        margin: 0 auto;
    }
    .login{
        display: none;
    }
}
</style>