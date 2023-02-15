<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="content">
        <Link href="/" class="logo">
            <img src="../../../public/img/Foodder_logo.png" alt="Foodder" >
        </Link>
        <div class="component">
            <slot />
        </div>
    </div>
</template>

<style scoped>
.content{
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100vh;
    background-color: #FFF3E0;
}
.logo{
    width: 13rem;
    margin: 0 auto 30px auto;
}
.component{
    width: 16rem;
    margin: 0 auto;
}
</style>
