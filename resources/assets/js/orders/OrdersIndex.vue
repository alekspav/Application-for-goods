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
                        <td>{{ order.status }}</td>
                        <td>{{ order.client_email }}</td>
                        <td>{{ order.partner_id }}</td>
                        <td>{{ order.delivery_dt }}</td>
                        <td>
                            <router-link :to="{name: 'editOrder', params: {id: company.id}}" class="btn btn-xs btn-default">
                                Редактировать
                            </router-link>
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               v-on:click="deleteEntry(company.id, index)">
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
    export default {
        data: function () {
            return {
                orders: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/orders')
                .then(function (resp) {
                    app.orders = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Невозможно загрузить заказы");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Вы хотите удалить заказ?")) {
                    var app = this;
                    axios.delete('/api/orders/' + id)
                        .then(function (resp) {
                            app.orders.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Нельзя удалить заказ");
                        });
                }
            }
        }
    }
</script>