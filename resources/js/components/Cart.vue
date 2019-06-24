<template>
    <div>
        <div v-if="isEmpty" style="font-size: 30px;">
            Ваша корзина пуста
        </div>
        <div v-else class="d-flex flex-column">
            <table class="table">
                <thead class="bg-light">
                <td></td>
                <td>Наименование</td>
                <td>Цена</td>
                <td>Количество</td>
                <td></td>
                </thead>
                <tbody>
                <cart-item v-for="item in items"
                           v-bind:key="item.id"
                           :item_id="item.id"
                           :name="item.name"
                           :count="$store.state.cart[item.id].count"
                           :img="item.img"
                           :amount="item.amount"
                           :price="item.price"
                ></cart-item>
                </tbody>
            </table>
            <div class="mt-5 align-self-end">
                <p style="font-size: 25px">Итого {{total}} &#8381</p>
                <perform-button :items="items"></perform-button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Cart",
        props: {
            items: {
                default: {}
            }
        },
        components: {
            'cart-item': require('./CartItem.vue').default,
            'perform-button': require('./PerformButton').default,
        },
        methods: {
            delete_item(item_id) {

                let cart = this.$store.state.cart;
                this.$delete(cart, item_id);
                this.$store.commit('updateCart', cart);


                this.$delete(this.items, item_id);

                axios           //send message about delete to server

                    .post('/cart',
                        {
                            'action': 'delete',
                            'item_id': item_id,
                        },
                        {
                            'X-CSRF-Token': this.getCookie('XSRF-TOKEN'),
                            'Content-Type': 'application/x-www-form-urlencoded',
                        })
            }
        },
        computed: {
            total() {
                let total = 0;
                let cart = this.$store.state.cart;
                for (let item_id in cart) {
                    let items = this.items;
                    let price = items[item_id].price;
                    total += cart[item_id].count * price;
                }
                return total;
            },
            isEmpty() {
                let cart = this.$store.state.cart;
                return Object.entries(cart).length === 0;
            }
        },
        watch: {

        }

    }
</script>

<style scoped>

</style>