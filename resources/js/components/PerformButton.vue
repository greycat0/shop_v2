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
                    <div class="modal-body d-flex flex-column">
                        <table class="table table-hover">
                            <tbody>
                            <tr>
                                <td>
                                    Имя
                                </td>
                                <td>
                                    <input>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Фамилия
                                </td>
                                <td>
                                    <input>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Отчество
                                </td>
                                <td>
                                    <input>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Адрес
                                </td>
                                <td>
                                    <div class="position-relative" style="width: 100%">
                                        <input style="width: 70%;" id="suggest">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    E-Mail
                                </td>
                                <td>
                                    <input>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Номер телефона
                                </td>
                                <td>
                                    <input>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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
                                <td>
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
                        <button class="btn btn-primary align-self-center my-5"
                                style="width: 200px"
                                data-toggle="modal">Оформить
                        </button>
                    </div>
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
            }
        },
        mounted() {
            ymaps.ready(this.init);
        },
        computed: {
            total() {
                let cart = this.$store.state.cart;
                let total = 0;
                for (let item_id in cart) {
                    let items = this.d_items;
                    let price = items[item_id].price;
                    total += cart[item_id].count * price;
                }
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
</style>