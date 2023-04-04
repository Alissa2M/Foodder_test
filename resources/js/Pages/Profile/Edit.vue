<script setup>
import { onMounted, nextTick, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import ResponsiveHeader from '@/Components/ResponsiveHeader.vue';
import TimelinePost from '@/Components/TimelinePost.vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    calenders:Array
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
                <span>お気に入り</span>
                <!-- 投稿する -->
                <div class="direct_row" ref="wrapperRef">
                    <div class="container" ref="containerRef">
                        <TimelinePost v-bind:calenders-array="calenders" v-bind:liked-post="true"/>
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

.direct_row{
    overflow-x: scroll;
    margin-bottom:100px;
}

.container{
    display: flex;
    flex-direction: row;
    gap: 10px;
}
::v-deep .posts_box{
    min-width: 45%;
    margin: 5px auto 30px;
}

::v-deep .img_box{
    height:25vw;
}

::v-deep .shop_box{
    width: 100%;
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
}
</style>