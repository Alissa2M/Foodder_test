<script setup>
const props = defineProps({
    showTriangle:{
        type:Boolean,
        default:true
    },
    userBox:{
        type:Boolean,
        default:false
    }
})
</script>

<template>
    <div class="chat_box" :class="{'user_box':userBox}">
        <div :class="{'triangle':showTriangle}"></div>
        <slot/>
    </div>
</template>

<style scoped>
.chat_box{
    position: relative;
    max-width: fit-content;
    padding: 8px;
    margin: 5px 0;
    background-color: #fff;
    border-radius: 10px;
    filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.123));
}
.triangle{
    position: absolute;
    top: 15px;
    left: -5px;
    width: 10px;
    height: 10px;
    background-color: #fff;
    transform: rotate(45deg); 
    z-index: -100;
    
}
.user_box{
    margin-left: auto;
    background-color: #f1f1f1;
}
</style>