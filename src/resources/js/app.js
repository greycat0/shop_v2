/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vuex = require('vuex');
window.Vue = require('vue');
const qs = require('qs')

const { Input, Select, Button, Carousel, message } = require('ant-design-vue')
require('ant-design-vue/lib/message/style/css.js')
require('ant-design-vue/lib/input/style/index.css')
require('ant-design-vue/lib/select/style/index.css')
require('ant-design-vue/lib/button/style/index.css')
require('ant-design-vue/lib/carousel/style/index.css')

Vue.use(Input)
Vue.use(Select)
Vue.use(Button)
Vue.use(Carousel);
Vue.use(Vuex);

Vue.prototype.$qs = qs
Vue.prototype.$message = message;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.getCookie = function(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

const store = new Vuex.Store({
    state: {
        itemCount: 0,
        cart: {},
        isAdmin: false,
        categoryFilter: null,
        categories: null,
        items: []
    },
    mutations: {
        updateCart (state, cart) {
            state.cart = cart;
            state.itemCount = Object.keys(cart).length;
            document.cookie = encodeURI("cart=" + JSON.stringify(cart)) + "; path=/";
        },
        init (state) {
            state.cart = this.getters.cart;
            state.itemCount = Object.keys(state.cart).length;
            state.categoryFilter = qs.parse(window.location.search.slice(1)).category
            var xhr = new XMLHttpRequest()
            xhr.open ('post', '/categories', true)
            xhr.setRequestHeader('X-XSRF-TOKEN', getCookie('XSRF-TOKEN'))
            xhr.send ()
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    try {
                        state.categories = JSON.parse(xhr.responseText)
                    }catch (e) {
                        state.categories = []
                    }
                }
            }
        },
        setItems(state, items) {
            state.items = items;
        },
        deleteItem (state, item) {
            Vue.delete(state.items, state.items.indexOf(
                    state.items.find(el => el.id === item)))
        },

        setCategoryFilter(state, filter) {
            state.categoryFilter = filter
        },
        addCategory (state, category) {
            if (category)
                state.categories.push(category)
        },
        deleteCategory (state, category) {
            if (category)
                Vue.delete(state.categories, state.categories.indexOf(
                    state.categories.find(el => el.id === category)))
        },
        updateCategory (state, category) {
            if (category) {
                Vue.set(state.categories, state.categories.indexOf(
                    state.categories.find(el => el.id === category.id)),
                    category)
            }
        }
    },
    getters: {
        cart(state) {
            let cart
            try {
                cart = JSON.parse(decodeURIComponent(getCookie('cart')));
            } catch (e) {
                cart = {};
            }
            if (typeof (cart) != 'object') {
                cart = {};          //if couldn't
            }
            return cart;
        }
    }
});
store.commit('init');

const app = new Vue({
    el: '#app',
    store,
    components: {
        'toggle-admin': require('./components/ToggleAdmin').default,
        'items': require('./components/Items.vue').default,
        'item': require('./components/Item.vue').default,
        'cart-button': require('./components/CartButton').default,
        'cart': require('./components/Cart.vue').default,
        'create-item': require('./components/CreateItem.vue').default,
        'category-tab': require('./components/CategoryTab.vue').default,
    },
    mounted() {
        window.ymapsLoaded = () => {
            this.$emit('ymaps-loaded')
        }
    }
});