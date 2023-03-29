<script setup>
defineProps(['message']);
</script>

<template>
    <div v-show="message">
        <p class="error_message">
            {{ message }}
        </p>
    </div>
</template>

<style scoped>
.error_message{
    color: red;
    font-size: 12px;
    margin-top: 3px;
}
</style>