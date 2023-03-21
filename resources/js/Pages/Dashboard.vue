<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import BaseModal from '@/Components/BaseModal.vue';
import { Head, useForm } from '@inertiajs/vue3';
import BasePost from '@/Components/BasePost.vue';

const props = defineProps({
    date: String,
    category: Array,
});

const form = useForm({
    title:'',
    description:'',
    start:props.date,
    file:'',
    category_id:2,
    anonymous:true,
    shop_name: '',
});

// 投稿するボタン
const clickSend = () => {
    submit()
}

const submit = () => {
    form.post(route('dashboard.store'), {
        forceFormData: true
    });
};

// カテゴリプルダウン
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

// const origin = ref();

onMounted(()=>{
    addEventListener('click',detectOutsideClick);
    // 店舗検索
    // const options = {
    //     componentRestrictions: {country: 'jp'} ,
    //     types: ["establishment"],
    //     fields: ["name"],       
    // };
    // const autocomplete = new google.maps.places.Autocomplete(origin.value, options);
    // autocomplete.addListener("place_changed", () => {
    //     const place = autocomplete.getPlace();
    //     form.shop_name = place.name;
    // })
})
onBeforeUnmount(()=>{
    removeEventListener('click',detectOutsideClick);
})

// モーダル表示
const photoPreview = ref('');
const file = ref('');
const photoUrl = ref('');
const showPhoto = ref(false);
const showDefaultImg = ref(true);
const showPost = ref(false);

const uploadPhoto = () => {
    file.value = photoPreview.value.files[0];
    photoUrl.value = URL.createObjectURL(file.value);
    showPhoto.value = true;
    showDefaultImg.value = false;
    form.file = photoPreview.value.files[0];
}

const closeModal = () => {
    showPost.value = false;
}

const postClick = () => {
    showPost.value = true;
}
</script>

<template>
    <Head title="投稿画面" />
    <form @submit.prevent="submit">
        <AuthenticatedLayout :href="'/'" v-on:click-button="clickSend">
            <template #main>
                <div class="form_style">
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
                                <span class="category_color" :class="(chooseCategoryColor === 1)?'category_green':(chooseCategoryColor === 2)?'category_yellow':(chooseCategoryColor === 3)?'category_blue':(chooseCategoryColor === 4)?'category_purple':''"></span>
                                <span>{{ chooseCategoryName }}</span>
                                <input type="hidden" name="category_id" v-model="form.category_id">
                            </div>
                            <div class="select_box" v-show="showOption">
                                <div v-for="(value, key) in props.category" class="category_color_box" :key="key"  @click="clickOption(value.id)" :class="value.category_name === chooseCategoryName?'selected_category':''">
                                    <span class="category_color" :class="(value.color==='blue')?'category_blue':(value.color === 'green')?'category_green':(value.color === 'yellow')?'category_yellow':(value.color === 'purple')?'category_purple':''"></span>
                                    <span class="category_name">{{ value.category_name }}</span>
                                    <input type="hidden" :value="value.id">
                                </div>
                            </div>
                        </div>
                        <div>
                            <!-- フード名 -->
                            <InputError :message="form.errors.title" />
                            <input type="text" v-model="form.title" name="title" placeholder="フード名(必須)" class="underline_input">
                            <span class="word_length">{{form.title.length}}/30文字</span>
                        </div>
                        <div>
                            <!-- メモ -->
                            <InputError :message="form.errors.description" />
                            <input type="text" v-model="form.description" name="description" placeholder="メモ" class="underline_input">
                            <span class="word_length">{{form.description.length}}/30文字</span>
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
                        <!-- 写真 -->
                        <label for="photo" class="photo_label">
                            画像をアップロード
                            <input id="photo" type="file" name="file" accept="image/*;capture=camera" class="photo_input" @change="uploadPhoto" ref="photoPreview">
                        </label>
                        <InputError :message="form.errors.file" />
                    </div>
                </div>
                <div class="preview_hr"></div>
                <!-- 投稿プレビュー -->
                <div class="input_confirm" @click="postClick">
                    <div class="photo_box">
                        <div class="default_img" v-if="showDefaultImg"></div>
                        <img :src="photoUrl" alt="画像表示" class="photo_review" v-if="showPhoto">
                    </div>
                    <div class="preview_content">
                        <BasePost :three-point="true" :title="form.title" :description="form.description" :start="form.start" :shop-name="form.shop_name"/>
                    </div>
                </div>
            </template>
            <template #footer>
                <i class="fa-solid fa-paper-plane send_icon"></i>
            </template>
        </AuthenticatedLayout>
    </form>
    <BaseModal v-bind:show="showPost" v-bind:show-title="false" v-on:close="closeModal">
        <div class="img_box" v-if="photoUrl">
            <img :src="photoUrl" class="food_img">
        </div>
        <BasePost :three-point="false" :title="form.title" :description="form.description" :start="form.start" :modal="true" :text-position="true" :shop-name="form.shop_name"/>
    </BaseModal>

</template>

<style scoped>
/* 投稿 */
.form_style{
    position: relative;
    width: 90%;
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
    gap: 10px 0;
    margin-top: 15px;
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
    margin-bottom: 5px;
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
/* 画像アップロード */
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
    vertical-align: bottom;
}
/* 点線 */
.preview_hr{
    width: 90%;
    margin: 30px auto 20px;
    border-bottom: 2px dashed #FFC107;
}
/* 投稿プレビュー */
.input_confirm{
    display: flex;
    flex-direction: row;
    width: 90%;
    height: 80px;
    margin: 0 auto;
    background: #FFFFFF;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 15px; 
    overflow: hidden;
}
.photo_box{
    width: 80px;
    height:80px;
    flex-shrink: 0;
}
.photo_review{
    width: 80px;
    height: 80px;
    object-fit:cover;
    object-position: 50% 50%;
    flex-shrink: 0;
}
.default_img{
    width: 80px;
    height: 80px;
    background-color: #D9D9D9;
    background-image: url("../../../public/img/no_image.png");
    background-size: contain;
    background-position: 50% 50%;
    background-repeat: no-repeat;
}
.preview_content{
    display: flex;
    flex-direction: column;
    flex-grow: 1;
    padding: 5px 10px;
    overflow-y: auto;
}
.img_box{
    position: relative;
    width: 100%;
    height: 50vw;
    margin: 8px 0;
    background-color: #c9c9c9;
    border: 1px solid #c9c9c9;
    overflow: hidden;
}
.food_img{
    height: 50vw;
    width: 100%;
    object-fit: cover;
}
/* フッター */
.send_icon{
    color: #fff;
    font-size: 18px;
}
</style>