<template>
    <div class="m-2 item d-flex flex-column justify-content-center">
            <img class="img mt-auto" @click="redirect( item_url(item_id))" v-bind:src="'img/' + img">
        <h4 class="mt-auto">
            <a :href="item_url( item_id)" >
                {{name}}
            </a>
        </h4>
        <h4 class="text-danger font-weight-bold">
            {{price}} &#8381;
        </h4>
        {{data}}
    </div>
</template>

<script>
    export default {
        name: "ItemPreview",
        props: [
            'img',
            'name',
            'price',
            'item_id',
        ],
        methods: {
            item_url(item_id)
            {
                return 'item/' + item_id;
            },
            redirect( url)
            {
                location = url;
            }
        }
    }
</script>

<style scoped>
    .item{
        width: 200px;
        height: 260px;
        display: inline-block;
        word-wrap: break-word;
        overflow: hidden;
    }
    .img{
        height: 200px;
        width: 100%;
        object-fit: contain;
    }
    .item:hover
    {
        border-left: 1px lightgray solid;
        border-right: 1px lightgray solid;
    }

    a, a:active, a:hover, a:link, a:visited{
        color: black;
        border: none;
        text-decoration: none;
    }
</style>
