<template>
    <div>
        <a :href="category_url(category_id)">{{category_name}}</a>
        <div class="d-flex flex-row justify-content-center justify-content-sm-start mt-3">
            <div class="d-flex flex-column flex-sm-row ">
                <div class="d-flex flex-column">
                    <img :src="'/img/' + img">
                </div>


                <div class="d-inline-flex flex-column align-items-center align-items-sm-start ml-5">
                    <h1>
                        {{name}}
                    </h1>
                    <div class="text-danger font-weight-bold item-price mt-3">
                        {{price}} &#8381;
                    </div>
                    <counter :max="amount" :number="count" @counter="updateCount" class="mt-auto"></counter>
                    <bue-button :count="count" :item_id="item_id" class="mt-2 mb-5 w-75"></bue-button>
                </div>
            </div>
        </div>
        <h1 class="mt-5">
            Описание товара
        </h1>
        <div class="item-desc-content">
            {{desc}}
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                count: 1
            }
        },
        props: [
            'item_id',
            'category_id',
            'category_name',
            'name',
            'price',
            'desc',
            'img',
            'amount',
        ],
        components: {
            'bue-button': require('./BueButton.vue').default,
            'counter': require('./Counter.vue').default,
        },
        methods:{
            category_url(category_id)
            {
                return '/' + '?category='+ category_id;
            },
            updateCount(data){
                //console.log(data);
                this.count = data;
            }
        },
    }
</script>

<style scoped>

    .item-price{
        font-size: 35px;
        font-weight: bold;
        color: red;
    }
    .item-desc-content{
        font-size: 14px;
    }
</style>