<script setup>
import { ref } from 'vue';

const props = defineProps({
    userCheck:{
        type:Object,
        defualt:null,
    },
    calenderId:Number,
    likeNumber:Number,
    likeCheck:Boolean,
})

// いいねをクリック
const goodNumber = ref(props.likeNumber);
const goodCheck = ref(props.likeCheck);

const clickHeart = (id) => {
    if(props.userCheck === null){
        location.href='/login';
    }
    else if(goodCheck.value){
        unlike(id)
        goodNumber.value -= 1,
        goodCheck.value = false
    }else{
        like(id)
        goodNumber.value += 1,
        goodCheck.value = true
    }
}

//いいね付与
const like = async(id) => {
    await axios.post('/timeline',{
        calenderId: props.calenderId,
    }).catch((e)=>{
        console.error(e)
    });
}

//いいね解除
const unlike = async(id) => {
    const payload = {
        calenderId: props.calenderId,
    }
    await axios.delete('/timeline',{
        data:payload
    }).catch((e)=>{
        console.error(e)
    })

}
</script>

<template>
    <div class="good_box hover:cursor-pointer" >
        <span  @click="clickHeart(props.calenderId)" >
            {{ goodNumber }}
            <i class="fa-solid fa-heart common_button heart" :class="{'heart_active':goodCheck}"></i>
        </span>
    </div>
</template>

<style scoped>
.good_box{
    font-size: 10px;
    color: #FF6F00;
    text-align: end;
    margin-top: auto;
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
    padding: 4px;
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