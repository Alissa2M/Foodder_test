<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import BaseButton from '@/Components/BaseButton.vue';

defineProps({
    canResetPassword: Boolean,
});

const form = useForm({
    email: '',
    password: '',
    remember: true,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="ログイン" />
        <form @submit.prevent="submit" class="form_style">
            <div>
                <TextInput
                    type="email"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="メールアドレス"
                />
            </div>
            <div>
                <TextInput
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    placeholder="パスワード"
                />
                <InputError :message="form.errors.email" />
                <InputError :message="form.errors.password" />
            </div>         
            <BaseButton button-name="ログイン"/>
            <div class="reset_password">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="click_here"
                >
                    ※パスワードを忘れた場合
                </Link>
            </div>
        </form>
        <hr>
        <div class="sns_login_group">
            <a href="/" class="sns_login twitter" role="button">
                Twitterでログイン
            </a>
            <a href="/login/facebook" class="sns_login facebook" role="button">
                Facebookでログイン
            </a>
            <a href="/login/google" class="sns_login google" role="button">
                Googleでログイン
            </a>
        </div>
        <p class="to_resigter">アカウントをお持ちでない方は<Link :href="route('register')" class="click_here">こちら</Link></p>
    </GuestLayout>
</template>

<style scoped>
.form_style{
    display: flex;
    flex-direction: column;
    gap: 10px;
    font-size: 12px;
    text-align: center;
}

.reset_password{
    width: 100%;
    text-align: right;
}
.to_resigter{
    font-size: 12px;
    text-align: center;
}
.click_here{
    color:#0000ee;
}
hr{
    margin: 10px 0;
}
.sns_login_group{
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin: 15px 0;
}
.sns_login{
    width: 100%;
    font-size: 14px;
    text-align: center;
    background-color: #fff;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    padding: 6px 0;
}

.twitter{
    background-image: url(../../../../public/img/Twitter_icon.png);
    background-repeat: no-repeat;
    background-size:20px;
    background-position:5% 50% ;
}
.facebook{
    background-image: url(../../../../public/img/facebook_icon.png);
    background-repeat: no-repeat;
    background-size:25px;
    background-position:4% 50% ; 
}
.google{
    background-image: url(../../../../public/img/google_icon.png);
    background-repeat: no-repeat;
    background-size:20px;
    background-position:5% 50% ;
}
</style>