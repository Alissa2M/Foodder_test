<script setup>
import TheFooter from '@/Components/TheFooter.vue';

</script>

<template>
    <div class="main">
        <h2>用途</h2>
        <h3>食事日記</h3>
        <div>
            <img src="" alt="">
            <p></p>
        </div>
        <h3>飯テロ</h3>
        <div>
            <img src="" alt="">
            <p></p>
        </div>
        <h3>ＡＩチャット</h3>
        <div>
            <img src="" alt="">
            <p></p>
        </div>

        <h2>目次</h2>
        <dl>
            <dt>カレンダー</dt>
            <dd><a href="">過去の食事を投稿する</a></dd>
            <dd><a href="">直近5回分の投稿を見る</a></dd>
            <dt>タイムライン</dt>
            <dd><a href="">いいねする</a></dd>
            <dd><a href="">他のユーザーの投稿を見る</a></dd>
            <dt>ＡＩチャット</dt>
            <dd><a href="">レシピ検索する</a></dd>
            <dd><a href="">店舗検索する</a></dd>
            <dt>プロフィール</dt>
            <dd><a href="">プロフィールを設定する</a></dd>
            <dd><a href="">メールアドレスを変更する</a></dd>
            <dd><a href="">パスワードを変更する</a></dd>
            <dd><a href="">お気に入りを確認する</a></dd>
            <dt>投稿</dt>
            <dd><a href="">食べた日付を設定する</a></dd>
            <dd><a href="">カテゴリーを設定する</a></dd>
            <dd><a href="">匿名で投稿する</a></dd>
            <dd><a href="">画像を投稿する</a></dd>
        </dl>

        <h2>使い方</h2>
    </div>
    <TheFooter></TheFooter>
</template>

<style scoped>
.main{
    width: 90%;
    margin: 0 auto 100px;
}
h2{
    font-size: 26px;
    border-bottom: 1px solid #000;
    margin: 20px 0 10px;
}
h3{
    font-size: 20px;
}
dt{
    font-size: 20px;
    font-weight: bold;
}
</style>