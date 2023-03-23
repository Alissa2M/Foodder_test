<script setup>
import {useForm } from '@inertiajs/vue3';

const props = defineProps({
    chat_response:String,
})

const form = useForm({
    sentence:'',
});

const clickSend = () => {
    submit()
}

const submit = () =>{
    form.post(route('chat_gpt.chat'), {
        preserveState: true,
        onSuccess: (response) => {
            form.sentence = '';
        },
        onError: (error) => {
        console.log(error);
        },
    });

}
</script>

<template>
<form @submit.prevent="submit">
    <textarea rows="10" cols="50" name="sentence" v-model="form.sentence"></textarea>
    <button type="submit" @click="clickSend">ChatGPT</button>
</form>
<div v-if="props.chat_response">
    {{ props.chat_response }}
  </div>
  </template>
    