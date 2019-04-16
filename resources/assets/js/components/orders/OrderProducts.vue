<template>
    <div>
        <div class="row">
            <div class="col-xs-12 form-group">
                <a href="#"
                   class="btn btn-xs btn-secondary"
                   v-on:click="showModal()">
                    Выбрать продукт
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 form-group">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Ид</th>
                        <th>Наименование</th>
                        <th>Цена, руб.</th>
                        <th>Количество</th>
                        <th>Сумма, руб.</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="order_product, index in order_products">
                        <td>{{ order_product.id }}</td>
                        <td>{{ order_product.product.name }}</td>
                        <td>{{ order_product.product.price }}</td>
                        <td>{{ order_product.quantity }}</td>
                        <td>{{ order_product.product.price * order_product.quantity }}</td>
                        <td>
                            <router-link :to="{name: 'editProduct', params: {id: order_product.id}}"
                                         class="btn btn-xs btn-default">
                                Редактировать
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(order_product.id, index)">
                                Удалить
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p>
                    Итого: {{total_sum}} руб.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    /**
     * Получет продукты для заданного заказа orderId
     * @param integer orderId Идентификатор заказа
     * @param callback Функция для обработки полученных данных
     */
    const getProducts = (orderId, callback) => {
        axios
            .get('/api/get_products_by_order/'+orderId)
            .then(response => {
                callback(null, response.data);
            }).catch(error => {
            callback(error, error.response.data);
        });

    };


    /**
     *  Продукты для заданного заказа
     */
    export default {
        name: "OrderProducts",
        props: ['orderId'],
        data: function () {
            return {
                order_products: [],
                error: null
            }
        },
        computed: {
            /**
             * Сумма продуктов
             * @returns {integer}
             */
            total_sum() {
                let sum = 0;

                this.order_products.forEach(function(p) {
                    sum += p.product.price * p.quantity;
                });

                return sum;
            },
        },
        mounted() {
            getProducts(this.orderId, (err, data) => {
                this.setData(err, data);
            });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Вы хотите удалить продукт?")) {
                    axios.delete('/api/order_products/' + id)
                        .then((resp) => {
                            this.order_products.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Нельзя удалить продукт");
                        });
                }
            },
            //установка данных
            setData(err, {data: order_products}) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.order_products = order_products;
                }
            },
            //Показать модальное окно
            showModal() {
                this.$modal.show('dialog', {
                    title: 'Alert!',
                    text: 'You are too awesome',
                    buttons: [
                        {
                            title: 'Deal with it',
                            handler: () => {
                                alert('Woot!')
                            }
                        },
                        {
                            title: '',       // Button title
                            default: true,    // Will be triggered by default if 'Enter' pressed.
                            handler: () => {
                            } // Button click handler
                        },
                        {
                            title: 'Close'
                        }
                    ]
                })
            }
        }

    }
</script>