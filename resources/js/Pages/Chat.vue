<script setup>
import { ref, onMounted } from 'vue';
import {useForm, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BaseChat from '@/Components/BaseChat.vue';
import BaseChatBackground from '@/Components/BaseChatBackground.vue';

const props = defineProps({
    // 過去の会話の配列
    chat_responses:{
        type:Array,
        default:["こんにちは","何かお困りですか？\nお手伝いができることがありましたら、なんでも言ってください！","今日の天気は？","発表内容は、今日・明日・明後日の天気と風と波、明日までの6時間ごとの降水確率と最高・最低気温の予想です。「府県予報区」と「一次細分区域」について詳細は発表内容は、今日・明日・明後日の天気と風と波、明日までの6時間ごとの降水確率と最高・最低気温の予想です。「府県予報区」と「一次細分区域」について詳細は"]
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

const clickSend = () => {
    if(props.chat_responses){
        form.sentence.push(...props.chat_responses);
        form.sentence.push(inputMessage.value);
    }else{
        form.sentence = [inputMessage.value];
    }
    form.post(route('chat_gpt.chat'), {
        preserveState: true,
        onSuccess: (response) => {
            form.sentence = [];
            inputMessage.value = [];
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

// コンポーネントがマウントされた時に実行する処理
onMounted(() => {
    adjustHeight();
});

// footerの表示切り替え
const displayFooter = ref(false);

</script>

<template>
<!-- TODO:@focuesでFooterが消えて、input_boxのbottom:0に変更 -->
<!-- TODO：フォーム送信中は、送信中のアニメーション表示と送信ボタンを表示できないようにする -->
    <Head title="レシピ検索" />

    <AuthenticatedLayout :href="'/'" :display-curcle="false" :display-footer="displayFooter">
        <template #main>
            <div class="main" v-if="props.count === 6">
                <BaseChat v-bind:chats-response="props.chat_responses" />
                <!-- 入力欄 -->
            </div>
            <div class="main" v-else>
                <div class="foonya_box">
                    <div class="foonya"></div>
                    <BaseChatBackground>
                        <p>AIのふーにゃです。<br>【レシピ検索】が得意です！<br>文脈を理解できるけど…<br>1日<strong>3回</strong>で疲れます。。。</p>
                    </BaseChatBackground>
                </div>
                <!-- やり取り -->
                <BaseChat v-bind:chats-response="props.chat_responses" />
                <!-- 入力欄 -->
                <div class="input_content">
                    <form @submit.prevent="submit" class="input_box">
                        <span class="text_length">{{inputMessage.length}}/100文字</span>
                        <textarea maxlength="100" rows="1" name="sentence" v-model="inputMessage" @input="adjustHeight" ref="textarea" class="inputText"></textarea>
                        <i class="fa-solid fa-paper-plane send_chat" @click="clickSend"></i>
                    </form>
                </div>
            </div>
            <p v-if="props.count === 6" class="max_chat">※１日の利用制限に達しました。明日もう一回使ってね！</p>
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
    height: calc(100vh - 120px);
    overflow: auto;
    margin: 0 auto;
    padding: 0 5px;
}
.input_content{
    /* flex-grow: 1; */
    position: sticky;
    bottom: 0px;
    background-color: #FFF3E0;
    padding: 25px 0 2px;
    margin-top: 15px;
    border-top: 2px dashed #FFC107;
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
    margin: 50px auto;
}
</style>