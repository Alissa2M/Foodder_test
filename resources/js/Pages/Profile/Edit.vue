<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';


defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});
</script>

<template>
    <Head title="プロフィール" />
    <AuthenticatedLayout v-bind:href="'/dashboard'">
        <template #main>
            <div class="fooder_logo">
                <Link href="/">
                    <img src="../../../../public/img/Foodder_logo.png" alt="Foodder">
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
            <img src="../../../../public/img/plus.png" alt="post">
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>
.fooder_logo{
    width: 13rem;
    margin: 30px auto;
}
.form{
    width: 90vw;
    margin: 0 auto;
    padding: 25px;
    background-color: #fff;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 10px;
}
.logout{
    display: block;
    font-size: 12px;
    padding: 0 25px;
    margin: 5px 0 100px auto;
}
</style>