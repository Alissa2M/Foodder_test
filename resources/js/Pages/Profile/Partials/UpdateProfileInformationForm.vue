<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
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
    user_icon:'',
    user_header: '',
});

const editClicked = ref(false); //保存するボタン
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
    form.post(route('profile.update'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
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

const userHeaderPreview = ref('');
const userHeader = ref(user.user_header);

const changeUserHeader = () => {
    const file = ref('');
    file.value = userHeaderPreview.value.files[0];
    userHeader.value = URL.createObjectURL(file.value);
    form.user_header = userHeaderPreview.value.files[0];
    editClicked.value = true;
}

const userIconPreview = ref('');
const userIcon = ref(user.user_icon);

const changeUserIcon = () => {
    const file = ref('');
    file.value = userIconPreview.value.files[0];
    userIcon.value = URL.createObjectURL(file.value);
    form.user_icon = userIconPreview.value.files[0];
    editClicked.value = true;
}

const modal = ref();
const clickOutside = (e) => {
    if(!modal.value.contains(e.target)) {
        form.reset()
        userIcon.value = user.user_icon
        userHeader.value = user.user_header
        editPassword.value = false;
        editEmail.value = false;
    }
}
onMounted(() => {
    addEventListener('click', clickOutside)
})
onBeforeUnmount(() => {
    removeEventListener('click', clickOutside)
})
</script>

<template>
    <form @submit.prevent="updateProfile" ref="modal">
        <label for="header_photo">
            <input id="header_photo" type="file" name="user_header" class="header_input" @change="changeUserHeader" ref="userHeaderPreview">
            <img src="../../../../../public/img/header.jpg" alt="header" class="header" v-if="!userHeader"/>
            <img :src="userHeader" alt="ヘッダー" class="header" v-else>
        </label>
        <div class="icon_box">
            <div class="position_box">
                <label for="user_icon">
                    <input id="user_icon" type="file" name="user_icon" class="header_input" @change="changeUserIcon"  ref="userIconPreview">
                    <img src="../../../../../public/img/guest.png" alt="icon" class="icon" v-if="!userIcon"/>
                    <img :src="userIcon" alt="アイコン" class="icon" v-else>
                </label>
                <div v-if="!editUsername" class="dummy_box" v-on:click="clickEditUsername">
                    <span class="username_dummy">{{ form.name }}</span>
                    <i class="fa-solid fa-pen edit_pen"></i>
                </div>
                <TextInput
                    v-else
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
            <div v-if="form.recentlySuccessful" class="success text-green-700">保存しました</div>
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
            <InputError :message="form.errors.user_header" />
            <InputError :message="form.errors.user_icon" />
        </div>
        <!-- 保存するボタン -->
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
.header_input{
    display: none;
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
    justify-content: flex-end;
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