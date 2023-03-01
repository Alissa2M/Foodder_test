<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    date: Date,
    category: Array,
});

const form = useForm({
    title:'',
    description:'',
    start:props.date,
    img_path:'',
    // user_id:'',
    category_id:2,

});

// const submit = () => {
//     // form.post(route('login'), {
//     //     onFinish: () => form.reset('password'),
//     // });
// };

const chooseCategoryColor = ref(2);
const chooseCategoryName = ref("昼");
const showOption = ref(false);
const showSelect = ref(true);

const clickSelect = () => {
    showOption.value = !showOption.value;
    showSelect.value = false;
}

const clickOption = (e) => {
    chooseCategoryName.value = props.category[e-1].category_name
    chooseCategoryColor.value = e;
    form.category_id = e;
    showSelect.value = true;
    showOption.value = false;
}

const detectOutsideClick = (event) => {
    if(!event.target.closest('div.index_option')){
        showOption.value = false;
        showSelect.value = true;
    }
}
onMounted(()=>{
    addEventListener('click',detectOutsideClick);
})
onBeforeUnmount(()=>{
    removeEventListener('click',detectOutsideClick);
})

const addMore = () => {
    console.log("追加")
}

</script>

<template>
    <Head title="投稿画面" />

    <AuthenticatedLayout v-bind:href="'/'">
        <template #header>
            <Link href="/profile">
                <i class="fa-solid fa-circle-user"></i>
            </Link>
        </template>
        <template #main>
            <form @submit.prevent="submit" class="form_style">
                <div class="top">
                    <span class="top_circle"></span>
                    <span class="top_circle"></span>
                    <span class="top_circle"></span>
                </div>
                <div class="input_content">
                    <div class="date_category">
                        <!-- 日付 -->
                        <input type="date" v-model="form.start" name="start" class="input_form date_form">
                        <!-- カテゴリ -->
                        <div class="index_option" @click="clickSelect" v-show="showSelect">
                            <span class="category_color" :class="(chooseCategoryColor === 1)?'category_blue':(chooseCategoryColor === 2)?'category_green':(chooseCategoryColor === 3)?'category_yellow':(chooseCategoryColor === 4)?'category_purple':''"></span>
                            <span>{{ chooseCategoryName }}</span>
                            <input type="hidden" name="category_id" v-model="form.category_id">
                        </div>
                        <div class="select_box" v-show="showOption">
                            <div v-for="(value, key) in props.category" class="category_color_box" :key="key"  @click="clickOption(value.id)" :class="value.category_name === chooseCategoryName?'selected_category':''">
                                <span class="category_color" :class="(value.color==='青')?'category_blue':(value.color === '緑')?'category_green':(value.color === '黄')?'category_yellow':(value.color === '紫')?'category_purple':''"></span>
                                <span class="category_name">{{ value.category_name }}</span>
                                <input type="hidden" :value="value.id">
                            </div>
                        </div>
                    </div>
                    <div>
                        <!-- フード名 -->
                        <input type="text" v-model="form.title" name="title" placeholder="フード名" class="input_form">
                        <span class="word_length">{{form.title.length}}/30文字</span>
                    </div>
                    <div>
                        <!-- メモ -->
                        <input type="text" v-model="form.description" name="description" placeholder="メモ" class="input_form">
                        <span class="word_length">{{form.description.length}}/30文字</span>
                    </div>
                    <!-- 写真 -->
                    <label for="photo" class="photo_label">
                        画像をアップロード
                        <input id="photo" type="file" name="image" accept="image/*;capture=camera" class="photo_input">
                    </label>
                </div>
            </form>
            <div class="add_more">
                <span @click="addMore">
                    <i class="fa-solid fa-circle-plus"></i>
                    追加する
                </span>
            </div>
        </template>
        
        <template #footer>
            <i class="fa-solid fa-paper-plane send_icon"></i>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>
.send_icon{
    color: #fff;
    font-size: 18px;
}
.form_style{
    position: relative;
    width: 90vw;
    height: auto;
    margin: 30px auto 0;
    padding: 25px;
    background-color: #fff;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
}
.top{
    position: absolute;
    top: -25px;
    left: 0;
    right: 0;
    display: flex;
    flex-direction: row;
    justify-content: center;
    gap: 0 18vw;
}
.top_circle{
    height: 50px;
    width: 30px;
    border-radius: 50px;
    background-color: #FFF3E0;
    box-shadow: inset 0px -2px 1px rgba(0, 0, 0, 0.25);
}
.top_circle:before{
    content: "";
    display: block;
    height: 40px;
    width: 20px;
    margin: 5px auto 0;
    background-color: #FF8F00;
    border-radius: 50px;
}
.input_content{
    display: flex;
    flex-direction: column;
    gap: 2vh 0;
    margin-top: 2vh;
}
.input_form{
    width: 100%;
    padding: 5px 5px 0;
    background: #FFFFFF;
    border: none;
    box-shadow: inset 0px 4px 4px rgba(0, 0, 0, 0.25);
}
.input_form::placeholder{
    color: #D9D9D9;
}
.date_category{
    position: relative;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-bottom: 1.5vh;
}

.date_form{
    width: fit-content;
    color: #000;
    background-color: #FFF3E0;
}

.word_length{
    display: block;
    text-align: right;
    font-size: 12px;
}
.photo_input{
    display: none;
}
.photo_label{
    width: 100%;
    color: #fff;
    text-align: center;
    padding: 5px;
    background-color: #FF6F00;
    border-radius: 5px;
}
.index_option{
    position: relative;
    display: flex;
    flex-direction: row;
    width: 80px;
    padding: 3px 15px 3px 3px;
    border: 1px solid #D9D9D9;
    font-size: 14px;
}
.index_option::after{
    content: "";
    position: absolute;
    top: 9px;
    right: 5px;
    width: 5px;
    height: 5px;
    border-right: 1px solid #000;
    border-bottom: 1px solid #000;
    transform: rotate(45deg);
}
.selected_category{
    color: #fff;
    font-weight: bold;
    background-color: #FF8F00;
}
.select_box{
    position: absolute;
    top: 0;
    right: 0;
    width: 80px;
    border: 1px solid #D9D9D9;
    background-color: #fff;
}
.category_color_box{
    display: flex;
    flex-direction: row;
    padding: 3px;
    font-size: 14px;
}
.category_color{
    display: block;
    width: 20px;
    height: auto;
    margin-right: 3px;
}
.category_name{
    display: block;
}
.category_blue{
    background-color:blue;
}
.category_green{
    background-color:green;
}
.category_yellow{
    background-color:yellow;
}
.category_purple{
    background-color:purple;
}
.add_more{
    font-size: 14px;
    text-align: end;
    margin: 5px 25px 20px 0;
}
</style>