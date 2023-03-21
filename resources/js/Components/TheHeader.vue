<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <header>
        <a href="javascript:history.go(-1)" class="back_page">戻る</a>
        <Link href="/profile" >
            <i class="fa-solid fa-circle-user"></i>
        </Link>
    </header>
</template>

<style scoped>
header{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 90%;
    margin: 10px auto;
}
.back_page{
    font-size: 14px;
    padding-left: 18px;
    margin: auto 0;
    background-image: url("../../../public/img/back.webp");
    background-repeat: no-repeat;
    background-position: 0 50%;
    background-size: 13px;
}

</style>