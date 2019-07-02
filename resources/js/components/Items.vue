<template>
    <div>
        <div class="mb-5" style="font-size: 30px;">{{category.name}}</div>
        <div class="d-flex flex-row flex-wrap justify-content-center justify-content-sm-start">

            <div v-for="item in items">
                <item-preview
                        :name="item.name"
                        :price="item.price"
                        :img="item.img"
                        :item_id="item.id"
                ></item-preview>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Items",
        props: {
            items: {
                default: {}
            },
            category: ''
        },
        components: {
            'item-preview': require('./ItemPreview.vue').default,
        },
        mounted() {
            console.log(this.$store.state.isAdmin);
        }
    }
</script>

<style scoped>
    .new-item {
        width: 200px;
        height: 260px;
        border-color: #b3b3b3;
        border-radius: 3px;
        border-style: solid;
        border-width: 1px;
    }
</style>