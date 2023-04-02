<script setup>
import { ref } from 'vue';
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

const showPassword = ref(false);
const showPasswordConfirm = ref(false);
const clickPassword = () =>{
    showPassword.value = !showPassword.value
}
const clickPasswordConfirm = () =>{
    showPasswordConfirm.value = !showPasswordConfirm.value
}
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
                <div v-if="!showPassword">
                    <TextInput
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                        placeholder="パスワード"
                        class="password"
                    />
                    <span class="show_text_box" @click.stop="clickPassword"><i class="fa-regular fa-eye show_text"></i></span>
                </div>
                <div v-if="showPassword">
                    <TextInput
                        type="text"
                        v-model="form.password"
                        autocomplete="new-password"
                        placeholder="パスワード"
                        class="password"
                    />
                    <span class="show_text_box" @click.stop="clickPassword"><i class="fa-regular fa-eye-slash show_text"></i></span>
                </div>
            </div>
            <div>
                <div v-if="!showPasswordConfirm">
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="パスワード確認用"
                        class="password"
                    />
                    <span class="show_text_box" @click.stop="clickPasswordConfirm"><i class="fa-regular fa-eye show_text"></i></span>
                </div>
                <div v-if="showPasswordConfirm">
                    <TextInput
                        type="text"
                        v-model="form.password_confirmation"
                        autocomplete="new-password"
                        placeholder="パスワード確認用"
                        class="password"
                    />
                    <span class="show_text_box" @click.stop="clickPasswordConfirm"><i class="fa-regular fa-eye-slash show_text"></i></span>
                </div>
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
.show_text_box{
    position: relative;
}
.show_text{
    position: absolute;
    top: -0px;
    right: 5px;
}
.password{
    padding-right: 20px;
}
</style>