<template>
    <div>
        <button class="btn btn-primary" data-target="#performModal"
                data-toggle="modal">Оформить заказ
        </button>
        <div class="modal fade" id="performModal" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <h4 class="text-center justify-content-center my-5">
                        Оформление заказа
                    </h4>
                    <form action="/buy" @submit="apply">
                    <div class="modal-body d-flex flex-column">
                        <div class="table-container">
                            <table class="table table-hover">
                                <tbody>
                                    
                                        <tr>
                                            <td>
                                                Имя
                                            </td>
                                            <td>
                                                <input @input='normalstate' name='firstname'>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Фамилия
                                            </td>
                                            <td>
                                                <input @input='normalstate' name='secondname'>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Отчество
                                            </td>
                                            <td>
                                                <input @input='normalstate' name='thirdname'>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Адрес
                                            </td>
                                            <td>
                                                <div class="position-relative" style="width: 100%">
                                                    <input @input='normalstate' id="suggest" name=addres>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                E-Mail
                                            </td>
                                            <td>
                                                <input @input='normalstate' name='email'>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Номер телефона
                                            </td>
                                            <td>
                                                <input @input='normalstate' name='phonenumber'>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-container">
                            <table class="table mt-5">
                                <thead>
                                <th>

                                </th>
                                <th>
                                    Наименование
                                </th>
                                <th>
                                    Количество
                                </th>
                                <th>
                                    Цена
                                </th>
                                <th>
                                    Общая стоимость
                                </th>
                                </thead>
                                <tbody>
                                <tr v-for="item in items">
                                    <td class="td">
                                        <img :src="'/img/' + item.img" class="img">
                                    </td>
                                    <td style="word-break: break-word;">
                                        {{item.name}}
                                    </td>
                                    <td>
                                        {{$store.state.cart[item.id].count}}
                                    </td>
                                    <td>
                                        {{item.price}} &#8381
                                    </td>
                                    <td>
                                        {{$store.state.cart[item.id].count * item.price}} &#8381
                                    </td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th colspan="4"><h3>Итого</h3></th>
                                    <th><h3>{{total}} &#8381</h3></th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="align-self-center mt-5"
                             style="width: 20%; min-width: 90px;"
                        >
                        <button type='submit'
                                class="btn btn-primary d-block"
                                data-toggle="modal"
                                style="width: 100%"
                        >Оформить
                        </button>
                        <button type="button"
                                class="btn btn-secondary my-3 d-block" data-dismiss="modal"
                                style="width: 100%"
                        >Назад
                        </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "performButton",
        props: {
            items: {
                default: {}
            }
        },
        data() {
            return {
                d_items: this.$props.items
            }
        },
        methods: {
            init() {
                new ymaps.SuggestView('suggest');
            },
            apply(e) {
                var valid = true
                if (!e.target[0].value) {
                    valid = false 
                    e.target[0].classList.add("emptyField");
                }
                if (!e.target[1].value) {
                    valid = false
                    e.target[1].classList.add("emptyField");
                }
                if (!e.target[2].value) {
                    valid = false
                    e.target[2].classList.add("emptyField");
                }
                if (!e.target[3].value) {
                    valid = false
                    e.target[3].classList.add("emptyField");
                }
                if (!e.target[4].value) {
                    valid = false
                    e.target[4].classList.add("emptyField");
                }
                if (!e.target[5].value) {
                    valid = false
                    e.target[5].classList.add("emptyField");
                }
                if (valid === false) {
                    e.preventDefault()
                }
            },
            normalstate(e) {
                e.target.classList.remove('emptyField')
            }
        },
        mounted() {
            if (window.ymaps) {
                window.ymaps.ready(this.init);
            }
            this.$root.$on('ymaps-loaded', () => {
                window.ymaps.ready(this.init);
            });

        },
        computed: {
            total() {
                let cart = this.$store.state.cart;
                let total = 0;
                Object.keys(this.d_items).forEach( key => {
                    let price = this.d_items[key].price;
                    total += cart[key].count * price;
                });
                return total;
            }
        }
    }
</script>

<style scoped>
    input {
        height: 26px;
        border-color: #b3b3b3;
        border-radius: 4px;
        border-style: solid;
        border-width: 1px;
    }

    .img {
        height: 62px;
        width: 70px;
        object-fit: contain;
    }

    .td {
        width: 10%;
        padding: unset;
    }
    .emptyField {
        border-color: red;
        box-shadow: 0 0 5px 3px rgba(200, 0, 0, 0.2) !important;
    }
    .table-container {
        overflow-x: auto;
    }
</style>