<template>
    <a href="#" @click="delete_item">
        Удалить
    </a>
</template>

<script>
    export default {
        name: "DeleteButton",
        props:[
          'item_id'
        ],
        methods:{
            delete_item()
            {


                let cart = JSON.parse( this.getCookie('cart'));
                delete cart[this.item_id];
                document.cookie = encodeURI( "cart=" + JSON.stringify(cart)) + "; path=/";

                axios           //send message about delete to server

                    .post('/cart',
                    {
                        'action': 'delete',
                        'item_id': this.item_id,
                    },
                    {
                        'X-CSRF-Token': this.getCookie('XSRF-TOKEN'),
                        'Content-Type': 'application/x-www-form-urlencoded',
                    } )
                this.$emit('delete-item');
            }
        }
    }
</script>

<style scoped>

</style>