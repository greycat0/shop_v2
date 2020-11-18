<template>
	<nav class="navbar catalog-bg navbar-light btn-group">
            <div class="container p-0">
                <div class="navbar-brand">
                    Категории
                </div>
                <template v-if="$store.state.isAdmin">
                    <button @click="createCategory" class="mr-auto ml-2 btn btn-primary">Новая категория</button>
                        </template>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#catalog" aria-controls="#catalog" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="catalog">
                    <div id="category-tab" class="d-flex flex-wrap mt-2">
                        <template v-for="category in $store.state.categories">
                            <button
                            @contextmenu.prevent="context($event, category.id)"
                            @click="categoryClick(category.id)"
                            class="btn btn-info m-1"
                            >{{category.name}}
                            </button>
                        </template>
                    </div>
                </div>
            </div>
            <vue-context ref="menu">
                <template slot-scope="child" v-if="child.data">
                <li>
                    <button
                    style="width: 100%"
                    class="btn btn-light"
                    href="#"
                    @click.prevent="updateCategory(child.data.index)"
                    >Редактировать
                    </button>
                </li>
                <li>
                    <button
                    style="width: 100%"
                    class="btn btn-light"
                    href="#"
                    @click.prevent="deleteCategory(child.data.index)"
                    >Удалить
                    </button>
                </li>
                </template>
            </vue-context>
        </nav>
</template>

<script type="text/javascript">
import { VueContext } from 'vue-context';
export default {
    components: {
        VueContext
    },
	methods: {
        context($event, id) {
            if (this.$store.state.isAdmin) {
                this.$refs.menu.open($event, {
                    index: id
                })
            }
        },
		categoryClick (categoryID) {
                location = '/?category=' + categoryID
		},
        createCategory() {
            var name = prompt('Название новой категории')
            if (name) {
                const hide = this.$message.loading('Загрузка...', 0)
                var xhr = new XMLHttpRequest()
                xhr.open ('post', '/createcategory', true)
                xhr.setRequestHeader('X-XSRF-TOKEN', getCookie('XSRF-TOKEN'))
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
                xhr.send ('name=' + name)
                xhr.onreadystatechange = () => {
                if (xhr.readyState === 4
                    && xhr.responseText) {
                        hide()
                        this.$message.success('Готово!', 1.5)
                        this.$store.commit('addCategory', JSON.parse(xhr.responseText))
                    }
                }
            }
        },
        updateCategory(id) {
            var name = prompt('Название категории')
            if (name) {
                const hide = this.$message.loading('Загрузка...', 0)
                var xhr = new XMLHttpRequest()
                xhr.open ('post', '/updatecategory/' + id, true)
                xhr.setRequestHeader('X-XSRF-TOKEN', getCookie('XSRF-TOKEN'))
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
                xhr.send ('name=' + name)
                xhr.onreadystatechange = () => {
                if (xhr.readyState === 4
                    && xhr.responseText) {
                        hide()
                        this.$message.success('Готово!', 1.5)
                        this.$store.commit('updateCategory', JSON.parse(xhr.responseText))
                    }
                }
            }
        },
        deleteCategory(id) {
            if (id) {
                const hide = this.$message.loading('Загрузка...', 0)
                var xhr = new XMLHttpRequest()
                xhr.open ('post', '/deletecategory/' + id, true)
                xhr.setRequestHeader('X-XSRF-TOKEN', getCookie('XSRF-TOKEN'))
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
                xhr.send ()
                xhr.onreadystatechange = () => {
                if (xhr.readyState === 4
                    && xhr.responseText) {
                        hide()
                        if (id == this.$store.state.categoryFilter) {
                            this.$store.commit('setCategoryFilter', null)
                            history.replaceState({}, "", "/")
                        }  
                        this.$message.success('Готово!', 1.5)
                        this.$store.commit('deleteCategory', +xhr.responseText)

                        let delList = []
                        this.$store.state.items.forEach( item => {
                            if (item.category_id == id) {
                                delList.push(item.id)
                            }
                        })
                        delList.forEach( item => {
                            this.$store.commit('deleteItem', item)
                        });
                    }
                }
            }
        }
	},
}
</script>