<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import ResponsiveHeader from '@/Components/ResponsiveHeader.vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
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
    margin: 5px auto 100px;
    text-align: end;
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