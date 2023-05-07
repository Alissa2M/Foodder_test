<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import BaseChatBackground from './BaseChatBackground.vue';
import BaseModal from './BaseModal.vue';
import InputError from '@/Components/InputError.vue';
import BaseButton from '@/Components/BaseButton.vue';

const props = defineProps({
    chatsResponse:Array,
})

const form = useForm({
    title:'',
    recipe:'',
});

const showSave = ref(false);
const clickSave = (text) => {
    showSave.value = true;
    form.recipe = text;
}

const closeModal =() => {
    showSave.value = false;
};

const submit = () => {
    form.post(route('chat_gpt.chat'), {
        forceFormData: true,
        onSuccess: (response) => {
            form.reset('title');
            setTimeout(() => {
                location.reload();
            }, 1000);
        },
    });
};

// テキストエリア縦幅可変
const adjustHeight = (event) => {
    event.target.style.height = 'auto';
    event.target.style.height = `${event.target.scrollHeight}px`;
};

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
                <div class="select_box">
                    <span @click="clickSave(chat)">保存する</span>
                </div>
            </BaseChatBackground>
        </div>
    </div>
    <BaseModal v-bind:show="showSave" v-bind:show-title="false" v-on:close="closeModal">
        <form @submit.prevent="submit">
            <!-- フード名 -->
            <InputError :message="form.errors.title" />
            <textarea type="text" v-model="form.title" name="title" placeholder="フード名(必須)" class="underline_input" @input="adjustHeight" rows="1"></textarea>
            <span class="word_length">{{form.title.length}}/30文字</span>
            <!-- 保存するボタン -->
            <BaseButton button-name="レシピ保存"/>
        </form>
    </BaseModal>
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
    position: relative;
    word-wrap: break-word;
}
.select_box{
    position: absolute;
    bottom: -20px;
    right: 0;
    display: flex;
    flex-direction: row;
    justify-content: end;
    font-size: 12px;
    margin-top: 5px;
}
.underline_input{
    width: 100%;
    padding: 0 5px;
    border: none;
    border-bottom: 1px dashed #FF6F00;
    resize: none;
    overflow: hidden;
}
[type='text']:focus{
    outline:none;
    box-shadow: none;
}
.word_length{
    display: block;
    text-align: right;
    font-size: 12px;
}

</style>