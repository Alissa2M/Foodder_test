<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import BaseButton from '@/Components/BaseButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage} from '@inertiajs/vue3';

// ログインユーザー情報
const user = usePage().props.auth.user;

const form = useForm({
    email: user.email,
    current_password: '',
    password: '',
    password_confirmation: '',
});

// 編集項目
const editClicked = ref(false); //保存するボタン
const editEmail = ref(false);
const editPassword = ref(false);

const clickEditEmail = () => {
    editEmail.value = !editEmail.value;
    if(editPassword.value || editEmail.value){
        editClicked.value = true;
    }else{
        editClicked.value = false;
    }
}

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const clickEditPassword = () => {
    editPassword.value = !editPassword.value;
    if(editEmail.value || editPassword.value){
        editClicked.value = true;
    }else{
        editClicked.value = false;
    }
}

// 編集保存
const updateProfile = () => {
    form.post(route('profile.update'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
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

// 編集画面の中止（外側をクリック）
const modal = ref();
const clickOutside = (e) => {
    if(!modal.value.contains(e.target)) {
        form.reset()
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
        <!-- 選択肢 -->
        <div class="chose_edit">
            <span class="profile_title">プロフィール編集</span>
            <i class="fa-solid fa-envelope edit_icon" v-on:click="clickEditEmail"></i>
            <i class="fa-solid fa-key edit_icon" v-on:click="clickEditPassword"></i>
        </div>
        <!-- コンテンツ -->
        <div class="profile_contents">
            <div v-if="form.recentlySuccessful" class="success text-green-700">保存しました</div>
            <!-- メールアドレス変更 -->
            <div v-if="editEmail" class="email_box">
                <InputLabel for="email" value="メールアドレス"/>
                <TextInput
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    class="email"
                />
            </div>
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
            <InputError :message="form.errors.email" />
            <InputError :message="form.errors.current_password" />
            <InputError :message="form.errors.password" />
            <InputError :message="form.errors.password_confirmation"/>
        </div>
        <!-- 保存するボタン -->
        <BaseButton v-if="editClicked" button-name="保存する"/>
    </form>
</template>

<style scoped>
/* 選択肢 */
.profile_title{
    font-size: 16px;
    color: #000;
    margin-right:auto ;
}
.chose_edit{
    display: flex;
    gap: 0 8px; 
    justify-content: flex-end;
    font-size: 12px;
    margin-top: 5px;
    color: #fff;
}
.edit_icon{
    padding: 5px;
    background-color: #FF6F00;
    border-radius: 100%;
    box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25);
}
/* コンテンツ */
.email_box{
    margin-top: 10px;
}
.email{
    width: 100%;
    font-size: 14px;
    margin-bottom: 10px;
}
.change_password{
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 10px;
}
/* バリデーション */
.error{
    margin: 5px;
}
.success{
    font-size: 14px;
    text-align: center;
    margin: 10px auto;
}

/* レスポンシブ */
@media screen and (min-width:1024px) {
/*　画面サイズが1024pxからはここを読み込む　*/
    .header{
        height: 200px;
    }
}
</style>