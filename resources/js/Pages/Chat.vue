<script setup>
import { ref } from 'vue';
import {useForm } from '@inertiajs/vue3';

const props = defineProps({
    // 過去の会話の配列
    chat_responses:Array,
})

// 入力したメッセージ
const inputMessage = ref([]);

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

</script>

<template>

<!-- やり取り -->
<div v-for="(chat,index) in props.chat_responses">
    <!-- ユーザー欄 -->
    <div v-if="index === 0 || index === 2 || index === 4">
        あなた：{{ chat }}
    </div>
    <!-- 出力欄 -->
    <div v-else>
        AI：{{ chat }}
    </div>
</div>
<!-- 入力欄 -->
<div v-if="props.chat_responses">
    <!-- ３回以上のやりとりの場合は入力欄非表示 -->
    <p v-if="props.chat_responses.length > 4">利用制限に達しました。</p>
    <!-- 三回以内 -->
    <form @submit.prevent="submit" v-else>
        <textarea rows="10" cols="50" name="sentence" v-model="inputMessage"></textarea>
        <button type="submit" @click="clickSend">送信</button>
    </form>
</div>
<div v-else>
    <form @submit.prevent="submit">
        <textarea rows="10" cols="50" name="sentence" v-model="inputMessage"></textarea>
        <button type="submit" @click="clickSend">送信</button>
    </form>
</div>
</template>
    