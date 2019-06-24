<template>

    <tr>
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
            <counter @counter="updateCount" :max="amount" :value="count"></counter>
        </td>
        <td>
            <a href="#" @click="$parent.delete_item(item_id)">
                Удалить
            </a>
        </td>
    </tr>

</template>

<script>
    export default {
        props: [
            'item_id',
            'name',
            'count',
            'img',
            'amount',
            'price'
        ],
        components: {
            'counter': require('./Counter.vue').default,
        },
        methods: {
            updateCount(count) {
                let cart = this.$store.state.cart;
                cart[this.item_id].count = count;
                this.$store.commit('updateCart', cart);
            },

        }
    }
</script>

<style scoped>
    .img {
        height: 62px;
        width: 70px;
        object-fit: contain;
    }

    .td {
        width: 10%;
        padding: unset;
    }
</style>
