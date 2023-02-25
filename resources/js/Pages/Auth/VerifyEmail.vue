<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import BaseButton from '@/Components/BaseButton.vue';

const props = defineProps({
    status: String,
    email: String,
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <GuestLayout>
        <Head title="メールアドレス認証" />
        <div class="title">メールを確認してください！</div>
        <img src="../../../../public/img/email_send.png" alt="メール送信済み" class="email_send">
        <p class="email">{{ props.email }}宛てに認証メールが送信されました</p>
        <p class="verify_email">登録されているメールアドレスは認証が完了していません。メールを確認し、認証を完了してください。</p>
        <p v-if="verificationLinkSent" class="resend_email">
           ※認証メールを再送しましたので、ご確認ください。
        </p>
        <form @submit.prevent="submit">
            <BaseButton button-name="認証メールを再送信"/>
            <div class="to_logout">
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                >ログアウト
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>

<style scoped>
.title{
    font-size: 18px;
    font-weight: bold;
    text-align: center;
}
.email{
    text-align: center;
    font-weight: bold;
    margin-top: 20px;
}
.verify_email{
    font-size: 14px;
    margin: 20px 0;
}
.to_logout{
    font-size: 12px;
    text-align: center;
    margin-top: 10px;
}
.resend_email{
    font-size: 12px;
    text-align: center;
    color: #FF6F00;
}
.email_send{
    margin: 0 auto;
}
</style>