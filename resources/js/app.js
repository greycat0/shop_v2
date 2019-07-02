/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vuex = require('vuex');
window.Vue = require('vue');

Vue.use(Vuex);
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
Vue.prototype.ymaps = window.ymaps;

const store = new Vuex.Store({
    state: {
        itemCount: 0,
        cart: {},
    },
    mutations: {
        updateCart(state, cart) {
            state.cart = cart;
            state.itemCount = Object.entries(cart).length;
            document.cookie = encodeURI("cart=" + JSON.stringify(cart)) + "; path=/";
        },
        init(state) {
            state.cart = this.getters.cart;
            state.itemCount = Object.entries(state.cart).length;
        }
    },
    getters: {
        cart(state) {
            let name = 'cart';
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            let cart;
            try {
                cart = JSON.parse(decodeURIComponent(matches[1]));
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


Vue.mixin({
    methods: {
        getCookie(name) {
            var matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }
    }
});


const app = new Vue({
    el: '#app',
    store,
    components: {
        'items': require('./components/Items.vue').default,
        'item': require('./components/Item.vue').default,
        'cart-button': require('./components/CartButton').default,
        'cart': require('./components/Cart.vue').default,
    },
    mounted() {
        this.$store.commit('init');
    }
});