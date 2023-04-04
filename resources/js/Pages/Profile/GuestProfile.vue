<script setup>
import { ref,onMounted, nextTick } from 'vue';
import TheFooter from '@/Components/TheFooter.vue'
import TheHeader from '@/Components/TheHeader.vue';
import { Head,Link } from '@inertiajs/vue3';
import ResponsiveHeader from '@/Components/ResponsiveHeader.vue';
import TimelinePost from '@/Components/TimelinePost.vue';

const props = defineProps({
    users: Array,
    calenders:Array
})

const userHeader = ref(props.users[0].user_header);
const userIcon = ref(props.users[0].user_icon);

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
        <TheHeader />
        <ResponsiveHeader />
        <div class="foodder_logo">
            <Link href="/">
                <img src="../../../../public/img/Foodder_logo.webp" alt="Foodder">
            </Link>
        </div>
        <!-- ユーザー情報 -->
        <div class="form">
            <!-- ヘッダー画像 -->
            <div>
                <img src="../../../../public/img/header.webp" alt="header" class="header" v-if="!userHeader"/>
                <img :src="userHeader" alt="ヘッダー" class="header" v-else>
            </div>
            <div class="icon_box">
                <div class="position_box">
                    <!-- アイコン -->
                    <div>
                        <img src="../../../../public/img/guest.webp" alt="icon" class="icon" v-if="!userIcon"/>
                        <img :src="userIcon" alt="アイコン" class="icon" v-else>
                    </div>
                    <!-- ユーザーネーム -->
                    <div class="dummy_box">
                        <span class="username_dummy">{{ users[0].name }}</span>
                    </div>
                </div>
            </div>
        </div>
        <!-- お気に入り -->
        <span class="title">投稿</span>
        <div class="direct_row" ref="wrapperRef">
            <div class="container" ref="containerRef">
                <TimelinePost v-bind:calenders-array="props.calenders" v-bind:liked-post="true"/>
            </div>
        </div>
        <TheFooter :href="route('dashboard')">
            <i class="fa-solid fa-plus to_post"></i>
        </TheFooter>
</template>

<style scoped>
/* ヘッダー */
.foodder_logo{
    width: 13rem;
    margin: 30px auto;
}
/* ユーザー情報 */
.form{
    width: 90%;
    margin: 0 auto;
    padding: 25px 25px 90px;
    background-color: #fff;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
}
.header{
    height: 130px;
    width: 100%;
    object-fit: cover;
    border: #908D8D solid 1px;
}
.icon_box{
    position: relative;
    top: 0;
    left: 0;
}
.position_box{
    position: absolute;
    top: -35px;
    left: 0;
    right: 0;
    text-align: center;
    pointer-events: none
}
.icon{
    height: 70px;
    width: 70px;
    background-color: #fff;
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25);
    border-radius: 100%;
    object-fit: cover;
    margin: 0 auto;
    pointer-events: fill;
}
.dummy_box{
    width: fit-content;
    margin: 8px auto;
    pointer-events: fill;
}
.username_dummy{
    width: fit-content;
    font-weight: bold;
    margin-left:5px;
    margin-right: 5px;
}
/* 投稿 */
.title{
    display: block;
    width: 90%;
    margin: 30px auto 0;
}

.direct_row{
    overflow-x: scroll;
    background-color: #FFF3E0;
    margin-bottom:100px;
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
}

/* フッダー */
.to_post{
    color: #fff;
    font-size: 23px;
}

/* レスポンシブ */
@media screen and (min-width:1024px) {
/*　画面サイズが1024pxからはここを読み込む　*/
    .form{
        width: 1024px;
        margin: 20px auto;
    }
    .header{
        height: 200px;
    }
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