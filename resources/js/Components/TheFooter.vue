<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    calenderPage:{
        type:Boolean,
        default:false,
    },
    timelinePage:{
        type:Boolean,
        default:false,
    },
    chatPage:{
        type:Boolean,
        default:false
    },
    profilePage:{
        type:Boolean,
        default:false
    },
    displayFooter:{
        type:Boolean,
        default:false
    },
    displayCurcle:{
        type:Boolean,
        default:true,
    }
});
</script>

<template>
    <footer :class="{'hidden':props.displayFooter}">
        <Link :href="href" :class="{'circle_button':props.displayCurcle}">
            <slot/>
        </Link>
        <div class="footer_nav">
            <a href="/">
                <i class="fa-regular fa-calendar icon" :class="{'selected_icon':calenderPage}"></i>
            </a>
            <a href="/timeline">
                <i class="fa-regular fa-clock icon mr-10" :class="{'selected_icon':timelinePage}"></i>
            </a>
            <a href="/chat">
                <i class="fa-regular fa-comment-dots icon" :class="{'selected_icon':chatPage}"></i>
            </a>
            <a href="/profile">
                <i class="fa-regular fa-user icon" :class="{'selected_icon':profilePage}"></i>
            </a>
        </div>
    </footer>
</template>

<style scoped>
footer{
    position: fixed;
    bottom: 0;
    width: 100%;
    height: 60px;
    background-color: #FFC107;
    box-shadow: 0px -2px 4px rgba(0, 0, 0, 0.25);
}
a {
  -webkit-tap-highlight-color:rgba(0,0,0,0);
  cursor:pointer;
}
.circle_button{
    position: absolute;
    top: -25px;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 50px;
    height: 50px;
    margin: 0 auto;
    background-color: #FF6F00;
    border-radius: 100px;
    box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.25);
}
.footer_nav{
    display: flex;
    height: 100%;
    flex-direction: row;
    align-items: center;
    text-align: center;
    font-size: 20px;
    justify-content: space-between;
    width: 80%;
    margin: 0 auto;
}
.icon{
    color: #fff;
    padding: 10px;
}
.selected_icon{
    color:#FF6F00;
    font-weight: bold;
    border-radius: 100%;
    box-shadow: inset 1px 1px 4px rgba(0, 0, 0, 0.25);
}

/* レスポンシブ */
@media screen and (min-width:1024px) {
/*　画面サイズが1024pxからはここを読み込む　*/
    footer{
       display: none;
    }
}

</style>