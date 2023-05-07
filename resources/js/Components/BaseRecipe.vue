<script setup>
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    recipeDetail:Object,
    isReadonly:{
        type:Boolean,
        default:false
    },
    showCount:{
        type:Boolean,
        default:false,
    }
});

// テキストエリア縦幅可変
const adjustHeight = (event) => {
    event.target.style.height = 'auto';
    event.target.style.height = `${event.target.scrollHeight}px`;
};

const form = useForm({
    recipeId: props.recipeDetail.id,
    title:props.recipeDetail.title,
    recipe:props.recipeDetail.recipe,
});

const submit = () => {
    form.put(route('recipe.update'));
}
</script>

<template>
    <form @submit.prevent="submit" class="recipe_box">
        <div>
            <InputError :message="form.errors.title" />
            <textarea type="text" v-model="form.title" name="title" placeholder="フード名(必須)" class="underline_input" @input="adjustHeight" rows="1" v-bind:readonly="isReadonly"></textarea>
            <span class="word_length" v-show="showCount">{{form.title.length}}/30文字</span>
        </div>
        <div class="reciept_input">
            <label for="recipe">レシピ：</label>
            <textarea name="recipe"  v-model="form.recipe" id="recipe" cols="30" rows="12" v-bind:readonly="isReadonly">{{ form.recipe }}</textarea>
        </div>
        <slot />
    </form>
</template>

<style scoped>
.recipe_box{
    width: 90%;
    margin: 30px auto;
}
.underline_input{
    width: 100%;
    padding: 0 5px;
    border: none;
    border-bottom: 1px dashed #FF6F00;
    background-color: transparent;
    resize: none;
    overflow: hidden;
}
.underline_input:focus{
    border-bottom: 1px dashed #FF6F00;
}
[type='text']:focus{
    outline:none;
    box-shadow: none;
}
textarea{
    border: none;
}
textarea:focus{
    border: none;
    box-shadow: none;
}
.word_length{
    display: block;
    text-align: right;
    font-size: 12px;
}
.reciept_input{
    display: flex;
    flex-direction: column;
    margin: 20px 0;
}
</style>