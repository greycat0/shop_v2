<template>
    <div>
        <div v-if="isEmpty" style="font-size: 30px;">
            Ваша корзина пуста
        </div>
        <div v-if="!isEmpty">
            <table class="table">
                <thead class="bg-light">
                    <td></td>
                    <td>Наименование</td>
                    <td>Цена</td>
                    <td>Количество</td>
                    <td></td>
                </thead>
                <tbody>
                <cart-item v-for="item in JSON.parse(items)"
                           v-bind:key="item.data.id"
                           :item_id="item.data.id"
                           :name="item.data.name"
                           :count="item.count"
                           :img="item.data.img"
                           :amount="item.data.amount"
                           :price="item.data.price"
                           @update-item="recheck()"
                ></cart-item>
                </tbody>
            </table>
            <div align="right" class="mt-5">
                <p style="font-size: 25px">Итого {{total}} &#8381</p>
                <button class="btn btn-primary">Оформить заказ</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Cart",
        data(){
          return {
              'isEmpty': true,
              'total': 0
          }
        },
        props: {
            items: {
                default: []
            }
        },
        components: {
            'cart-item': require('./CartItem.vue').default,
        },
        mounted() {

            this.recheck();
            $("div").attr('disabled', 'disabled');
        },
        methods:{
            recheck() {
                let cart = this.$store.getters.cart;
                this.isEmpty = Object.entries(cart).length === 0;

                this.total = 0;
                for (let item_id in cart)
                {
                    let price = JSON.parse(this.items)[item_id].data.price;
                    this.total += cart[item_id].count * price;
                }
            },
        }
    }
</script>

<style scoped>

</style>