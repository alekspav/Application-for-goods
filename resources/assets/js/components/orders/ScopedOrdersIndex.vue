<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: 'createOrder'}" class="btn btn-success">Создать новый заказ</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Список заказов</div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Статус</th>
                        <th>Клиентская почта</th>
                        <th>Партнер</th>
                        <th>Доставлено</th>
                        <th width="100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="order, index in orders">
                        <td>{{ order.status_name }}</td>
                        <td>{{ order.client_email }}</td>
                        <td>{{ order.partner.name }}</td>
                        <td>{{ order.delivery_dt }}</td>
                        <td>
                            <router-link :to="{name: 'editOrder', params: {id: order.id}}"
                                         class="btn btn-xs btn-default">
                                Редактировать
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(order.id, index)">
                                Удалить
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    /**
     * Получет заказы
     * @param integer page Страница
     * @param callback Функция для обработки полученных данных
     */
    const getOrders = (scopeType, callback) => {
        axios
            .get('/api/scoped_orders/' + scopeType)
            .then(response => {
                callback(null, response.data);
            }).catch(error => {
            callback(error, error.response.data);
        });
    };

    /**
     * Компонент Для показа заказов
     * @type VueComponent
     */
    export default {
        props: ['scopeType'],
        data: function () {
            return {
                orders: [],
                error: null,
            }
        },
        //До подтверждения пути, соответствующему этому компоненту
        //this создасться не успел
        mounted() {
            getOrders(this.scopeType, (err, data) => {
                this.setData(err, data)
            });
        },

        methods: {
            deleteEntry(id, index) {
                if (confirm("Вы хотите удалить заказ?")) {
                    axios.delete('/api/orders/' + id)
                        .then((resp) => {
                            this.orders.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Нельзя удалить заказ");
                        });
                }
            },
            //установка данных
            setData(err, {data: orders}) {
                if (err) {
                    this.error = err.toString();
                } else {
                    console.log('gg');
                    this.orders = orders;
                }
            }
        },


    }

</script>