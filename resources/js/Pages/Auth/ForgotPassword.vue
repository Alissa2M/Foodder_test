<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import BaseButton from '@/Components/BaseButton.vue';
import BaseModal from '@/Components/BaseModal.vue';

const props = defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};

</script>

<template>
    <GuestLayout>
        <Head title="パスワード再設定" />

        <div class="title">パスワードの再設定</div>

        <p class="password_reset">ご利用中のメールアドレスを入力してください。<br>パスワード再設定のためのURLをお送りします。</p>

        <form @submit.prevent="submit">
            <div>
                <TextInput
                    type="email"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="メールアドレス"
                />
                <InputError :message="form.errors.email" />
            </div>
            <BaseButton v-bind:type="button" button-name="再設定メールを送信"/>
        </form>
        <p class="to_login"><Link :href="route('login')">ログイン画面へ戻る</Link></p>
        <BaseModal v-bind:show="props.status" v-on:close="closeModal" modal-title="メールをご確認ください">
            <p>{{ props.status }}<br>メールの内容に従ってパスワードを再設定してください。</p>
            <div class="return">
                <a href="/forgot-password">戻る</a>
            </div>
        </BaseModal>
    </GuestLayout>
</template>

<style scoped>
.title{
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px
}
.password_reset{
    font-size: 14px;
    text-align: center;
    margin-bottom: 30px;
}
.to_login{
    font-size: 12px;
    text-align: center;
    margin-top: 15px;
    color:#0000ee;
}
.return{
    text-align: center;
    margin-top: 20px;
    color: #0000ee;
}
</style>