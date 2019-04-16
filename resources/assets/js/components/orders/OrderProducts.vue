<template>
    <div>
        <div class="row">
            <div class="col-xs-12 form-group">
                Продукт:
                <select v-model="selected_product">
                    <option v-for="product in products" v-bind:value="product.id">{{product.name.concat(' (',
                        product.vendor.name, ')') }}
                    </option>
                </select>
                <a href="#"
                   class="btn btn-xs"
                   v-on:click="selectProduct()">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Добавить продукт
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
                        <td>
                            {{ order_product.product.price }}
                        </td>
                        <td>
                            <input min="1" v-model.number="order_product.quantity"
                                   v-on:input="quantityChange(order_product.id, order_product.quantity )"
                                   type="number">

                        </td>
                        <td>{{ order_product.product.price * order_product.quantity }}</td>
                        <td>
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
            .get('/api/get_products_by_order/' + orderId)
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
                error: null,
                products: [],
                selected_product: null
            }
        },
        computed: {
            /**
             * Сумма продуктов
             * @returns {integer}
             */
            total_sum() {
                let sum = 0;

                this.order_products.forEach(function (p) {
                    sum += p.product.price * p.quantity;
                });

                return sum;
            },
        },
        mounted() {
            getProducts(this.orderId, (err, data) => {
                this.setData(err, data);
            });

            let app = this;
            //Получает партнеров
            axios.get('/api/products')
                .then(function (resp) {
                    app.products = resp.data.data;
                })
                .catch(function () {
                    alert("Нельзя загрузить поставщиков")
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
            /**
             * Изменено количество товара
             * @param id Идентификатор
             * @param quantity Количество
             * @constructor
             */
            quantityChange(id, quantity) {
                console.log(id, quantity)
            },
            /**
             * Выбран новый товар
             */
            selectProduct() {
                console.log(this.selected_product);

            }

        }

    }
</script>