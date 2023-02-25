<script setup>
import { ref } from 'vue';

defineProps({
    buttonName: {
        type: String,
    },
    buttonType:{
        type: String,
        default: 'submit',
    }
});

const isShadow = ref(true);
const buttonClick = () => {
    isShadow.value = false;
    setTimeout(() => {
        isShadow.value = true}
        ,200
      )
}

</script>

<template>
    <div class="button_box">
        <button type="buttonType" v-bind:class="{'box_shadow': isShadow}" v-on:click="buttonClick">{{buttonName}}</button>
    </div>
</template>

<style scoped>
.button_box{
    height:40px;
    margin-top: 10px;
}
button{
    width: 100%;
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    background-color: #FF6F00;
    border-radius: 5px;
    padding: 6px 0;
    margin-top: 10px;
}
.box_shadow{
    box-shadow: 0px 4px 0px #A84700;
    margin-top: 5px;
}
</style>