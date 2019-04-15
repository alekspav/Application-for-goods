<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Назад</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Создаьт новый заказ</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Статус</label>
                            <input type="text" v-model="order.status" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Почта клиента</label>
                            <input type="text" v-model="order.client_email" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Партнер</label>
                            <input type="text" v-model="order.partner_id" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Доставлено</label>
                            <input type="text" v-model="order.delivery_dt" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Создать</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.companyId = id;
            axios.get('/api/orders/' + id)
                .then(function (resp) {
                    app.company = resp.data;
                })
                .catch(function () {
                    alert("Нельзя загрузить заказ")
                });
        },
        data: function () {
            return {
                orderId: null,
                order: {
                    status: '',
                    client_email: '',
                    partner_id: '',
                    delivery_dt: '',
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newOrder = app.order;
                axios.patch('/api/orders/' + app.orderId, newOrder)
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Нельзя создать заказ");
                    });
            }
        }
    }
</script>