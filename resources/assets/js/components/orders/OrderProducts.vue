<template>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Ид</th>
            <th>Наименование</th>
            <th>Поставщик</th>
            <th>Цена</th>
            <th width="100">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="product, index in products">
            <td>{{ product.id }}</td>
            <td>{{ product.name }}</td>
            <td>{{ product.vendor.name }}</td>
            <td>{{ product.price }}</td>
            <td>
                <router-link :to="{name: 'editProduct', params: {id: product.id}}"
                             class="btn btn-xs btn-default">
                    Редактировать
                </router-link>
                <a href="#"
                   class="btn btn-xs btn-danger"
                   v-on:click="deleteEntry(product.id, index)">
                    Удалить
                </a>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    /**
     * Получет продукты для заданного заказа orderId
     * @param integer orderId Идентификатор заказа
     * @param callback Функция для обработки полученных данных
     */
    const getProducts = (orderId, callback) => {
        axios
            .get('/api/get_products_by_order/'.orderId)
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
                products: [],
                error: null
            }
        },
        computed: {
            /**
             * Сумма продуктов
             * @returns {integer}
             */
            sum() {
                return 0;
            },
        },
        mounted() {
            getProducts(this.orderId, (err, data) => {
                this.setData(err, data);
                next();
            });
        },
        methods: {
            //установка данных
            setData(err, {data: products}) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.products = products;
                }
            }
        }

    }
</script>

<style scoped>

</style>