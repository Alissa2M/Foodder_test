<script setup>
const props = defineProps({
    threePoint: Boolean,
    title: String,
    description: String,
    start: String,
    shopName: String,
    modal: {
        type:Boolean,
        default:false,
    },
    textPosition: {
        type:Boolean,
        default:false,
    }
});
</script>

<template>
    <span class="food_name" :class="{'three_point':props.threePoint,'modal_food':modal,'text_position':textPosition}">{{ props.title }}</span>
    <p class="memo_review" :class="{'three_point':props.threePoint,'text_position':textPosition}">{{ props.description }}</p>
    <div class="box">
        <div class="shop_box">
            <i class="fa-solid fa-location-dot shop_icon" v-if="props.shopName"></i>
            <span class="shop_name three_point">{{ props.shopName }}</span>
        </div>
        <span class="ate_day">{{ props.start.replace(/-/g,'/') }}</span>
    </div>
</template>

<style scoped>
.food_name{
    font-size: 16px;
    font-weight: bold;
}
.memo_review{
    font-size: 14px;
}
.box{
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    justify-content: space-between;
    font-size: 12px;
    margin-top: auto;
}
.shop_box{
    display: flex;
    flex-direction: row;
    flex-wrap: nowrap;
    overflow: hidden;
    align-items: end;
}
.shop_icon{
    color: #FF6F00;
    margin-bottom: 3px;
}
.shop_name{
    white-space: nowrap;
    margin-left: 2px;
}
.ate_day{
    display: block;
    text-align: end;
    color: #908D8D;
    margin-top: 10px;
}
.three_point{
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.modal_food{
    display: block;
    font-size: 18px;
    margin: 15px auto 10px;
}
.text_position{
    text-align: start;
}
</style>