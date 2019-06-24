<template>
    <div>
        <button @click="bue" class="btn btn-primary" data-target="#buemodal"
                data-toggle="modal">
            Купить
        </button>

        <div class="modal fade" id="buemodal" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header text-center justify-content-center">
                        <h4>
                            Товар добавлен в корзину
                        </h4>
                    </div>
                    <div class="modal-body justify-content-center d-flex">
                        <button class="btn btn-primary mx-1" data-dismiss="modal">Продолжить покупки
                        </button>
                        <button onclick="location = '/cart'" class="btn btn-secondary mx-1">Перейти в
                            корзину
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        item_id: {
            default: 0
        },
        count: {
            default: 1
        }
    },
    methods: {
        bue() {

            // axios           //send item to server
            //     .post('/cart',
            //     {
            //         'action': 'add',
            //         'item_id': item_id,
            //         'count': this.count,
            //     },
            //     {
            //         'X-CSRF-Token': this.getCookie('XSRF-TOKEN'),
            //         'Content-Type': 'application/x-www-form-urlencoded',
            //     } )

            let cart = this.$store.state.cart;
            cart[this.item_id] = {count: this.count};
            this.$store.commit('updateCart', cart);
        },
    }
}
</script>

<style scoped>

</style>
