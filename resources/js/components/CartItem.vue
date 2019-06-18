<template>

    <tr v-if="isShow" class="">
            <td class="td">
                <img :src="'img/' + img" class="img">
            </td>
            <td>
                {{name}}
            </td>
            <td>
                {{price}} &#8381
            </td>
            <td>
                <counter @counter="$emit('update-item')" :item_id="item_id" :isCookie="true" :max="amount" :number="count"></counter>
            </td>
            <td>
                <delete-button @delete-item="delete_item()" :item_id="item_id"></delete-button>
            </td>
    </tr>

</template>

<script>
    export default {
        data(){
            return {
                'isShow': true
            }
        },
        props: [
            'item_id',
            'name',
            'count',
            'img',
            'amount',
            'price'
        ],
        components:{
            'delete-button': require('./DeleteButton.vue').default,
            'counter': require('./Counter.vue').default,
        },
        methods:{
            delete_item(){
                this.isShow = false;
                this.$emit('update-item');
            }
        }
    }
</script>

<style scoped>
    .img{
        height: 62px;
        width: 70px;
        object-fit: contain;
    }
    .td{
        width: 10%;
        padding: unset;
    }
</style>
