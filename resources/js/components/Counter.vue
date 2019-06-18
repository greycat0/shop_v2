<template>
    <div class="d-flex align-items-center">
        <button @click="changeCount(-1)" class="btn btn-primary my-btn ">
            -
        </button>
        <input maxlength="4" class="mx-1" v-model="count">
        <button @click="changeCount(1)" class="btn btn-primary my-btn">
            +
        </button>
    </div>
</template>

<script>
    export default {
        name: "Counter",
        data(){
            return {
                count: 0
            }
        },
        props:[
            'number',
            'max',
            'isCookie',
            'item_id'
        ],
        methods:{
            changeCount(inc)
            {
                if (this.count > 1 && inc < 0
                    || this.count < this.max && inc > 0)
                {
                    this.count = Number(this.count)
                    this.count += inc;
                }
                this.changeCookie(this.count);
                this.$emit('counter',this.count)
            },
            changeCookie(value){
                if (this.isCookie)
                {
                    let cart = JSON.parse( this.getCookie('cart'));
                    cart[this.item_id].count = value;
                    document.cookie = encodeURI( "cart=" + JSON.stringify(cart)) + "; path=/";
                }
            }
        },
        mounted() {

            this.count = this.number;

            let self = this;
            $('input').on('keypress', function(e){
                if( e.key.match(/[^0-9]/)
                    && e.key !== 'Backspace'
                    && e.key !== 'ArrowLeft'
                    && e.key !== 'ArrowRight'
                    && e.key !== 'F5'){
                    return false;
                }
            });
            $('input').on('input', function(e) {
                self.changeCookie(self.count);
            });
            $('input').on('blur', function(e){
                if (Number(self.count) === 0)
                {
                    self.count = 1;
                }
                if (Number(self.count) > self.max)
                {
                    self.count = self.max;
                }
                self.changeCookie(self.count);
                self.$emit('counter',self.count)
            })
        }
    }
</script>

<style scoped>
    input{
        text-align:center;
        width: 40px;
        height: 30px;
        border-color: #b3b3b3;
        border-radius: 3px;
        border-style: solid;
        border-width: 1px;
    }
    .my-btn{
        width:35px;
        line-height: 16px;
        font-size: 20px;

    }
    .minus-btn{
        background-color: #3468DC;
    }
</style>