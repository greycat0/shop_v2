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
            <counter @counter="updateCount" :max="amount" :value="count"></counter>
        </td>
        <td>
            <a href="#" @click="delete_item">
                Удалить
            </a>
        </td>
    </tr>

</template>

<script>
    export default {
        data() {
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
        components: {
            'counter': require('./Counter.vue').default,
        },
        methods: {
            updateCount(count) {
                let cart = this.$store.getters.cart;
                cart[this.item_id].count = count;
                this.$store.commit('updateCart', cart);

                this.$emit('update-item')
            },
            delete_item() {

                let cart = this.$store.getters.cart;
                delete cart[this.item_id];
                this.$store.commit('updateCart', cart);

                axios           //send message about delete to server

                    .post('/cart',
                        {
                            'action': 'delete',
                            'item_id': this.item_id,
                        },
                        {
                            'X-CSRF-Token': this.getCookie('XSRF-TOKEN'),
                            'Content-Type': 'application/x-www-form-urlencoded',
                        })


                this.isShow = false;
                this.$emit('update-item');
            }
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
