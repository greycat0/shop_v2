<template>
    <button onclick="location='/cart'" class="btn ml-auto mr-3" type="button">
        <img src="/svg/cart.svg" width="30" alt="">
        <span class="count px-1">{{count()}}</span>
    </button>
</template>

<script>
    export default {
        name: "CartButton",
        methods: {
            count(){
                let cart = JSON.parse( this.getCookie('cart'));
                let c = 0;
                for (let key in cart) {
                    c++;
                }
                console.log(c)
                return c;
            }
        }
    }
</script>

<style scoped>
    .count{
        border-radius: 10px;
        border-style: solid;
        border-width:2px;
        border-color: #3d42ff;
    }
</style>