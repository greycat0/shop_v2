<template>
    <div class="d-flex align-items-center">
        <button @click="changeCount(-1)" class="btn btn-primary my-btn ">
            -
        </button>
        <input maxlength="16" class="mx-1" v-model="count">
        <button @click="changeCount(1)" class="btn btn-primary my-btn">
            +
        </button>
    </div>
</template>

<script>
    export default {
        name: "Counter",
        data() {
            return {
                count: this.max !== 0 ? this.value : 0
            }
        },
        props: {
            value: {
                default: 1 ,
            },
            max: {
                default: Number.MAX_SAFE_INTEGER,
            },
        },
        methods: {
            changeCount(inc) {
                if (this.count > 1 && inc < 0
                    || this.count < this.max && inc > 0) {
                    this.count = Number(this.count)
                    this.count += inc;
                }
                this.$emit('counter',this.count)
            },
        },
        mounted() {
            let self = this;
            $(this.$el.children[1]).on('keydown', function (e) {

                if (e.key.match(/[^0-9]/)
                    && e.key !== 'Backspace'
                    && e.key !== 'ArrowLeft'
                    && e.key !== 'ArrowRight'
                    && e.key !== 'Delete'
                ) {
                    return false;
                }
            });
            $(this.$el.children[1]).on('blur', function (e) {
                if (Number(self.count) === 0) {
                    self.count = 1;
                }
                if (Number(self.count) > self.max) {
                    self.count = self.max;
                }
                self.$emit('counter', self.count)
            })
        },
    }
</script>

<style scoped>
    input {
        text-align: center;
        width: 50px;
        height: 30px;
        border-color: #b3b3b3;
        border-radius: 3px;
        border-style: solid;
        border-width: 1px;
    }

    .my-btn {
        width: 35px;
        line-height: 16px;
        font-size: 20px;
    }
</style>