<script setup>
import { onMounted, nextTick, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ResponsiveHeader from '@/Components/ResponsiveHeader.vue';
import TimelinePost from '@/Components/TimelinePost.vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    calenders:Array,
    recipes:Array,
});

const form = useForm({
    recipeId:'',
    title:'',
    recipe:'',
});

const wrapperRef = ref(null);
const containerRef = ref(null);

onMounted(() => {
  nextTick(() => {
    const wrapper = wrapperRef.value;
    const container = containerRef.value;
    const center = (container.scrollWidth - wrapper.offsetWidth) / 2;
    wrapper.scrollLeft = center;
  });
});

const clickRecipe = (value) => {
    form.recipeId = value;
    form.get(route('recipe.index'));
}

const clickEdit = (value) => {
    form.recipeId = value;
    form.get(route('recipe.edit'));
}

const clickDelete = (value) => {
    form.recipeId = value;
    form.delete(route('recipe.delete'));
}
</script>

<template>
    <Head title="プロフィール" />
    <ResponsiveHeader :on-profile="true"/>
    <AuthenticatedLayout v-bind:href="'/dashboard'" :profile-page="true">
        <template #main>
            <div class="foodder_logo">
                <Link href="/">
                    <img src="../../../../public/img/Foodder_logo.webp" alt="Foodder">
                </Link>
            </div>
            <UpdateProfileInformationForm
                :must-verify-email="mustVerifyEmail"
                :status="status"
                class="form"
            />
            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="logout"
            >
                ログアウト
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
            </Link>
            <!-- お気に入り -->
            <div>
                <span class="title">お気に入り</span>
                <div class="direct_row" ref="wrapperRef">
                    <div class="container" ref="containerRef">
                        <TimelinePost v-bind:calenders-array="calenders" v-bind:liked-post="true"/>
                    </div>
                </div>
            </div>
            <!-- 保存したレシピ -->
            <div>
                <span class="title">保存したレシピ</span>
                <div class="direct_column">
                    <div v-for="(value,index) in recipes" class="recipe_box" @click="clickRecipe(value.id)">
                        <p class="three_point">{{ value.title }}</p>
                        <div>
                            <button type="button" @click.stop="clickEdit(value.id)"><i class="fa-solid fa-pen icon"></i></button>
                            <button type="button" @click.stop="clickDelete(value.id)"><i class="fa-solid fa-trash-can icon"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <i class="fa-solid fa-plus to_post"></i>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>
.foodder_logo{
    width: 13rem;
    margin: 30px auto;
}
.form{
    width: 90%;
    margin: 0 auto;
    padding: 25px;
    background-color: #fff;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
}
.logout{
    display: block;
    font-size: 12px;
    width: 90%;
    margin: 5px auto 10px;
    text-align: end;
}
.title{
    display: block;
    width: 90%;
    margin: auto;
}
/* お気に入り */
.direct_row{
    overflow-x: scroll;
    background-color: #FFF3E0;
    margin-bottom:10px;
}

.container{
    display: flex;
    flex-direction: row;
    gap: 10px;

}
::v-deep .posts_box{
    width: 90%;
    min-width: 45%;
    margin: 5px auto 30px;
}

::v-deep .img_box{
    height:15vh;
}

::v-deep .shop_box{
    width: 100%;
    height: 18px;
}
/* 保存したレシピ */
.direct_column{
    width: 90%;
    height: 250px;
    margin: 10px auto;
    overflow-y: scroll;
}
.icon{
    width: 22px;
    height: 22px;
    color: #FF6F00;
    font-size: 10px;
    padding: 5px;
    margin: 0 2px;
    border: 1px solid #FF6F00;
    border-radius: 100%
}
.recipe_box{
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    margin: 0 2px 10px;
    padding: 5px 10px;
    background-color: #fff;
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
    
}
.three_point{
    width: 82%;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* フッダー */
.to_post{
    color: #fff;
    font-size: 23px;
}

/* レスポンシブ */
@media screen and (min-width:1024px) {
/*　画面サイズが1024pxからはここを読み込む　*/
    .foodder_logo{
        display: none;
    }
    ::v-deep .posts_box{
        width: 20%;
        min-width: 20%;
        margin: 5px 0 30px;
    }
}
</style>