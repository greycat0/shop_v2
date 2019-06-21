<template>
    <button onclick="location='/cart'" class="btn ml-auto mr-3" type="button">
        <img src="/svg/cart.svg" width="30" alt="">
        <span class="count px-1">{{$store.state.itemCount}}</span>
    </button>
</template>

<script>
    export default {
        name: "CartButton",
    }
</script>

<style scoped>
    .count{
        border-radius: 10px;
        border-style: solid;
        border-width:2px;
        border-color: #5959ff;
    }
</style>