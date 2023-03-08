<script setup>
const props = defineProps({
    threePoint: Boolean,
    title: String,
    description: String,
    start: String,
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
    <span class="ate_day">{{ props.start.replace(/-/g,'/') }}</span>
</template>

<style scoped>
.food_name{
    font-size: 16px;
    font-weight: bold;
}
.memo_review{
    font-size: 14px;
}
.ate_day{
    display: block;
    text-align: end;
    font-size: 12px;
    color: #908D8D;
    margin-top: auto;
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