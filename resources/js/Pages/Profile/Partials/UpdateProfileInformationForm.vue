<script setup>
import { ref } from 'vue';
import BaseButton from '@/Components/BaseButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage} from '@inertiajs/vue3';

const user = usePage().props.auth.user;

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    name: user.name,
    email: user.email,
    current_password: '',
    password: '',
    password_confirmation: '',

});

const editClicked = ref(false);
const editUsername = ref(false);
const editEmail = ref(false);
const editPassword = ref(false);

const clickEditUsername = () => {
    editUsername.value = true;
    editClicked.value = true;
}
const clickEditEmail = () => {
    editEmail.value = !editEmail.value;
    if(editUsername.value || editPassword.value || editEmail.value){
        editClicked.value = true;
    }else{
        editClicked.value = false;
    }
}
const clickEditPassword = () => {
    editPassword.value = !editPassword.value;
    if(editUsername.value || editEmail.value || editPassword.value){
        editClicked.value = true;
    }else{
        editClicked.value = false;
    }
}

const updateProfile = () => {
    form.put(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            editUsername.value = false;
            editPassword.value = false;
            editEmail.value = false;
            editClicked.value = false;
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};

const checkUsername = (event) => {
    if(user.name === event.target.value){
        editUsername.value = false;
        editClicked.value = false;
    }
}
</script>

<template>
    <form @submit.prevent="updateProfile">
        <img src="../../../../../public/img/header.jpg" alt="header" class="header" />
        <div class="icon_box">
            <div class="position_box">
                <img src="../../../../../public/img/guest.png" alt="icon" class="icon"/>
                <div v-if="!editUsername" class="dummy_box" v-on:click="clickEditUsername">
                    <span class="username_dummy">{{ form.name }}</span>
                    <i class="fa-solid fa-pen edit_pen"></i>
                </div>
                <TextInput
                    v-if="editUsername"
                    type="text"
                    v-model="form.name"
                    v-on:change="checkUsername"
                    required
                    autofocus
                    autocomplete="name"
                    class="username focus:ring-0"
                />
            </div>
        </div>
        <!-- 選択肢 -->
        <div class="chose_edit">
            <i class="fa-solid fa-envelope edit_icon" v-on:click="clickEditEmail"></i>
            <i class="fa-solid fa-key edit_icon" v-on:click="clickEditPassword"></i>
        </div>
        <!-- コンテンツ -->
        <div class="profile_contents">
            <div v-if="form.recentlySuccessful" class="success text-green-700">変更しました</div>
            <InputLabel v-if="editEmail" for="email" value="メールアドレス" />
            <TextInput
                v-if="editEmail"
                id="email"
                type="email"
                v-model="form.email"
                required
                autocomplete="username"
                class="email"
            />
            <!-- パスワードを変更 -->
            <div v-if="editPassword" class="change_password">
                <div>
                    <InputLabel for="current_password" value="現在のパスワード" />
                    <TextInput
                        id="current_password"
                        ref="currentPasswordInput"
                        v-model="form.current_password"
                        type="password"
                        autocomplete="current-password"
                    />
                </div>
                <div>
                    <InputLabel for="password" value="新しいパスワード" />
                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        autocomplete="new-password"
                    />
                </div>
                <div>
                    <InputLabel for="password_confirmation" value="新しいパスワード（確認用）" />
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        autocomplete="new-password"
                    />
                </div>
            </div>
        </div>
        <!-- バリデーション -->
        <div class="error">
            <InputError :message="form.errors.name" />
            <InputError :message="form.errors.email" />
            <InputError :message="form.errors.current_password" />
            <InputError :message="form.errors.password" />
            <InputError :message="form.errors.password_confirmation"/>
        </div>
        <BaseButton v-if="editClicked" button-name="保存する"/>
    </form>
</template>

<style scoped>
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
    width: auto;
    background-color: #fff;
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25);
    border-radius: 100%;
    object-fit: cover;
    margin: 0 auto;
}
.dummy_box{
    width: fit-content;
    margin: 8px auto;
    pointer-events: fill;
}
.username_dummy{
    width: fit-content;
    font-weight: bold;
    margin-left:15px;
    margin-right: 5px;
}
.edit_pen{
    font-size: 10px;
    color: #FF6F00;
}
.username{
    width: 100%;
    padding: 8px 0;
    text-align: center;
    font-weight: bold;
    border: none;
    text-decoration: underline #FF6F00 dotted;
    text-underline-offset: 5px;
    pointer-events: fill;
}
.chose_edit{
    display: flex;
    gap: 0 5px; 
    justify-content: end;
    font-size: 12px;
    margin-top: 5px;
    color: #fff;
}
.profile_contents{
    margin-top: 60px;
}
.email{
    width: 100%;
    font-size: 14px;
    margin-bottom: 10px;
}
.error{
    margin: 5px;
}
.edit_icon{
    padding: 5px;
    background-color: #FF6F00;
    border-radius: 100%;
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25);

}
.change_password{
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.success{
    font-size: 14px;
    text-align: center;
    margin: 10px auto;
}
</style>