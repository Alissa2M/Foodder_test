<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import BaseButton from '@/Components/BaseButton.vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="会員登録" />
        <form @submit.prevent="submit" class="form_style">
            <div>
                <p class="length">{{form.name.length}}/30文字</p>
                <TextInput
                    type="text"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="ユーザーネーム"
                    maxlength="30"
                />
                <InputError :message="form.errors.name" />
            </div>
            <div>
                <TextInput
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="メールアドレス"
                />
                <InputError :message="form.errors.email" />
            </div>
            <div>
                <TextInput
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="パスワード"
                />
            </div>
            <div>
                <TextInput
                    id="password_confirmation"
                    type="password"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="パスワード確認用"
                />
                <InputError :message="form.errors.password" />
                <InputError :message="form.errors.password_confirmation" />
            </div>
            <BaseButton button-name="新規登録"/>
            <p>アカウントをすでにお持ちな方は<Link :href="route('login')" class="click_here">こちら</Link></p>          
        </form>
    </GuestLayout>
</template>

<style scoped>
.form_style{
    display: flex;
    flex-direction: column;
    gap: 15px;
    font-size: 12px;
    text-align: center;
}
.length{
    text-align: right;
}
.click_here{
    color:#0000ee;
}
</style>