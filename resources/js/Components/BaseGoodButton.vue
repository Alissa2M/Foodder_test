<script setup>
import { ref } from 'vue';

const props = defineProps({
    goodDefault:{
        type:Number,
        defualt:0,
    }
})

const defaultHeart = ref(true);
const activeHeart = ref(false);
const goodNumber = ref(props.goodDefault);

const clickHeart = () => {
    defaultHeart.value = !defaultHeart.value;
    activeHeart.value = !activeHeart.value;
    if(activeHeart.value){
        goodNumber.value += 1; 
    }else{
        goodNumber.value -= 1;
    }
}
</script>

<template>
    <div>
        <div class="good_box">
            <span  @click="clickHeart">
                {{ goodNumber }}
                <i class="fa-solid fa-heart common_button" :class="{'heart':defaultHeart,'heart_active':activeHeart}"></i>
            </span>
        </div>
    </div>
</template>

<style scoped>
.good_box{
    font-size: 10px;
    color: #FF6F00;
    text-align: end;
}
.common_button{
    margin-left: 1px;
    border-radius: 100%;
}
.heart{
    border: 1px dashed #FF6F00;
    padding: 4px;
}
.heart_active{
    color: #fff;
    background-color: #FF6F00;
    padding: 5px;
    animation: eff 0.3s linear 0s forwards;
}
@keyframes eff{
    0%{
        transform: scale(1);
    }
    40%{
        transform: scale(0.6);
    }
    60%{
        transform: scale(1.3);
    }
    100%{
        transform: scale(1);
    }
}
</style>