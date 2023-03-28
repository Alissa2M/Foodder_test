<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import BaseButton from './BaseButton.vue';

const props = defineProps({
    editPost:Object,
    calenderId:Number,
});

const form = useForm({
    calenderId:props.calenderId,
    title:props.editPost.title,
    description:props.editPost.description,
    start:props.editPost.start,
    category_id:props.editPost.category_id,
    anonymous:props.editPost.anonymous,
    shop_name: props.editPost.shop_name,
});


// カテゴリプルダウン
const categories = ref([
    {
        id:1,
        color:'green',
        name:'朝'
    },
    {
        id:2,
        color:'yellow',
        name:'昼'
    },
    {
        id:3,
        color:'blue',
        name:'夜'
    },
    {
        id:4,
        color:'purple',
        name:'その他'
    },
])
const chooseCategoryColor = ref(3);
const chooseCategoryName = ref("夜");
const showOption = ref(false);
const showSelect = ref(true);

const clickSelect = () => {
    showOption.value = !showOption.value;
    showSelect.value = false;
}

const clickOption = (e) => {
    chooseCategoryName.value = categories.value[e-1].name
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

// 保存するボタン
const submitEdit = (e) => {
    form.put(route('update'),{
        onSuccess: () => {
            location.reload();
        }
    });
}


</script>

<template>
    <form @submit.prevent="submitEdit(props.calenderId)" class="input_content">
        <div class="date_category">
            <!-- 日付 -->
            <input type="date" v-model="form.start" name="start" class="input_form date_form">
            <!-- カテゴリ -->
            <div class="index_option" @click="clickSelect" v-show="showSelect">
                <span class="category_color" :class="(chooseCategoryColor === 1)?'category_green':(chooseCategoryColor === 2)?'category_yellow':(chooseCategoryColor === 3)?'category_blue':(chooseCategoryColor === 4)?'category_purple':''"></span>
                <span>{{ chooseCategoryName }}</span>
                <input type="hidden" name="category_id" v-model="form.category_id">
            </div>
            <div class="select_box" v-show="showOption">
                <div v-for="(value, key) in categories" class="category_color_box" :key="key"  @click="clickOption(value.id)" :class="value.name === chooseCategoryName?'selected_category':''">
                    <span class="category_color" :class="(value.color==='blue')?'category_blue':(value.color === 'green')?'category_green':(value.color === 'yellow')?'category_yellow':(value.color === 'purple')?'category_purple':''"></span>
                    <span class="category_name">{{ value.name }}</span>
                    <input type="hidden" :value="value.id">
                </div>
            </div>
        </div>
        <div>
            <!-- フード名 -->
            <InputError :message="form.errors.title" />
            <input type="text" v-model="form.title" name="title" placeholder="フード名(必須)" class="underline_input" maxlength="30" required>
            <span class="word_length">
                <span v-if="form.title">{{form.title.length}}</span>
                <span v-else>0</span>
                /30文字
            </span>
            
        </div>
        <div>
            <!-- メモ -->
            <InputError :message="form.errors.description" />
            <input type="text" v-model="form.description" name="description" placeholder="メモ" class="underline_input" maxlength="30">
            <span class="word_length">
                <span v-if="form.description">{{form.description.length}}</span>
                <span v-else>0</span>
                /30文字
            </span>
        </div>
        <div class="option_box">
            <!-- 店舗名 -->
            <i class="fa-solid fa-location-dot shop_icon"></i>
            <input type="text" placeholder="店舗名" ref="origin" v-model="form.shop_name" class="underline_input shop_name"/>
            <!-- 匿名 -->
            <div class="anonymous_box">
                <input type="checkbox" id="anonymous" name="anonymous" v-model="form.anonymous">
                <label for="anonymous" class="check_label">匿名投稿</label>
            </div>
        </div>
        <!-- 保存するボタン -->
        <BaseButton button-name="保存" />
    </form>
</template>

<style scoped>
.input_content{
    display: flex;
    flex-direction: column;
    gap: 10px 0;
    margin-top: 0;
}
.input_form{
    width: 100%;
    padding: 5px 5px 0;
    background: #FFF3E0;
    border: none;
    box-shadow: inset 0px 4px 4px rgba(0, 0, 0, 0.25);
}
.input_form::placeholder{
    color: #908D8D;
}
.underline_input{
    width: 100%;
    padding: 0 5px;
    border: none;
    border-bottom: 1px dashed #FF6F00;
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
/* 日付 */
.date_category{
    position: relative;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    margin-bottom: 10px;
}
.date_form{
    width: fit-content;
    color: #000;
    background-color: #FFF3E0;
}
/* カテゴリ */
.index_option{
    position: relative;
    display: flex;
    flex-direction: row;
    width: 85px;
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
/* 画像アップロード */
.food_img{
    width: fit-content;
    height: 50px;
    margin-top: 10px;
}
.photo_input{
    display: none;
}
.photo_label{
    width: 100%;
    font-size: 14px;
    color: #fff;
    text-align: center;
    padding: 5px;
    margin-top: 20px;
    background-color: #FF6F00;
    border-radius: 5px;
}
/* 店舗名 */
.option_box{
    display:flex;
    flex-direction: row;
}
.shop_icon{
    color: #FF6F00;
    margin: auto 0;
}
.shop_name{
    width: 50%;
}
.anonymous_box{
    margin-top: 5px;
    margin-left: auto;
}
[type='checkbox']:checked{
    background-color: #FF6F00;
}
[type='checkbox']:focus{
    box-shadow: none;
}
.check_label{
    font-size: 14px;
    margin-left: 5px;
}

</style>