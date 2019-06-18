<template>
    <div>
        <button @click="bue(item_id)" class="btn btn-primary" data-target="#buemodal"
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
    import bus from '../app.js'
export default {
    props:[
        'item_id',
        'count'
    ],
    methods: {
        bue(item_id) {

            if (!this.count)
            {
                this.count = 1;
            }

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

            let cart = {};
            if (this.getCookie('cart') !== undefined) {         //Getting current cart
                try{
                    cart = JSON.parse( this.getCookie('cart'));
                }catch(e){
                    cart = {};
                }
            }

            if ( typeof( cart) != 'object')
            {
                cart = {};          //if couldn't
            }

            cart[item_id] = {count: this.count};
            document.cookie = encodeURI( "cart=" + JSON.stringify(cart)) + "; path=/";
            
        },
    }
}
</script>

<style scoped>

</style>
