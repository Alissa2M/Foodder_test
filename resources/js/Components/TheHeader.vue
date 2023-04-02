<template>
    <header>
        <a href="javascript:history.go(-1)" class="back_page">戻る</a>
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

/* レスポンシブ */
@media screen and (min-width:1024px) {
/*　画面サイズが1024pxからはここを読み込む　*/
    header{
        display: none;
    }
}
</style>