<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import BaseButton from '@/Components/BaseButton.vue';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="パスワード再設定" />

        <div class="title">パスワードの再設定</div>

        <form @submit.prevent="submit" class="form_style">
            <div>
                <TextInput
                    type="email"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError :message="form.errors.email" />
            </div>
            <div>
                <TextInput
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="新規パスワード"
                />
                <InputError :message="form.errors.password" />
            </div>
            <div>
                <TextInput
                    type="password"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="新規パスワード（確認用）"
                />
                <InputError :message="form.errors.password_confirmation" />
            </div>
           <BaseButton button-name="パスワード再設定"/>
        </form>
    </GuestLayout>
</template>

<style scoped>
.form_style{
    display: flex;
    flex-direction: column;
    gap: 10px;
    font-size: 12px;
}

.title{
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;

}
</style>