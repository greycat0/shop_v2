<template>
    <div>
        <div class="mb-5" style="font-size: 30px;">{{category}}</div>
        <div class="d-flex flex-row flex-wrap">
            <div @click='createItem()' v-if="$store.state.isAdmin" class="new-item">
                <h3>Добавить</h3>
            </div>
            <div
            v-for="item in items"
            @contextmenu.prevent="context($event, item.id)"
            >
                <item-preview
                        class="btn111"
                        :name="item.name"
                        :price="item.price"
                        :img="item.img"
                        :item_id="item.id"
                ></item-preview>
            </div>
        </div>
        <vue-context ref="menu">
                <template slot-scope="child" v-if="child.data">
                <li>
                    <button
                    style="width: 100%"
                    class="btn btn-light"
                    href="#"
                    @click.prevent="updateItem(child.data.index)"
                    >Редактировать
                    </button>
                </li>
                <li>
                    <button
                    style="width: 100%"
                    class="btn btn-light"
                    href="#"
                    @click.prevent="deleteItem(child.data.index)"
                    >Удалить
                    </button>
                </li>
                </template>
        </vue-context>
    </div>
</template>

<script>
    import { VueContext } from 'vue-context';
    import { mapState } from 'vuex'
    export default { 
        name: "Items",
        components: {
            VueContext,
            'item-preview': require('./ItemPreview.vue').default,
        },
        computed: {
            ...mapState({
                items: state => state.items,
                category: state => {
                    if (!state.categories) return ""
                    let _category = state.categories
                    .find(category => category.id == state.categoryFilter)
                    return _category ? _category.name : "Все товары"
                }
            })
        },
        methods: {
            context($event, id) {
                if (this.$store.state.isAdmin) {
                    this.$refs.menu.open($event, {
                        index: id
                    })
                }
            },
            createItem () {
                window.location = '/creationitem' + ((this.$store.state.categoryFilter) ?
                '?category=' + this.$store.state.categoryFilter : '')
            },
            updateItem (itemID) {
                location = '/item/' + itemID
            },
            deleteItem (itemID) {
                const hide = this.$message.loading('Загрузка...', 0)
                var xhr = new XMLHttpRequest()
                xhr.open ('post', '/deleteitem/' + itemID, true)
                xhr.setRequestHeader('X-XSRF-TOKEN', getCookie('XSRF-TOKEN'))
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
                xhr.send ()
                xhr.onreadystatechange = () => {
                if (xhr.readyState === 4
                    && xhr.responseText) {
                        hide()
                        this.$message.success('Готово!', 1.5)
                        this.$store.commit('deleteItem', itemID)
                    }
                }
            }
        },
        mounted() {
            var xhr = new XMLHttpRequest()
            xhr.open ('get', '/items' + (this.$store.state.categoryFilter ?
               '?category=' + this.$store.state.categoryFilter : '') , true)
            xhr.setRequestHeader('X-XSRF-TOKEN', getCookie('XSRF-TOKEN'))
            xhr.send ()
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    try {
                        this.$store.commit('setItems', JSON.parse(xhr.responseText))
                    }catch (e) {
                        this.$store.commit('setItems', [])
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .new-item {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 200px;
        height: 260px;
        border: none;
    }
    .new-item:hover {
        border-left: 1px lightgray solid;
        border-right: 1px lightgray solid;
    }
</style>