<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Назад</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Обновить заказ</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Статус</label>
                            <select class="form-control" v-model="order.status">
                                <option value="0">Новый</option>
                                <option value="10">Подтвержден</option>
                                <option value="20">Завершен</option>
                            </select>
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
                            <select v-model="order.partner_id" class="form-control">
                                <option v-for="partner in partners" v-bind:value="partner.id">{{partner.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Доставлено</label>
                            <datetime format="YYYY-MM-DD h:i:s" width="300px" v-model="order.delivery_dt"></datetime>
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
    import datetime from 'vuejs-datetimepicker';

    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.orderId = id;
            axios.get('/api/orders/' + id)
                .then(function (resp) {
                    app.order = resp.data;
                })
                .catch(function () {
                    alert("Нельзя загрузить заказ")
                });

            axios.get('/api/partners')
                .then(function (resp) {
                    app.partners = resp.data;
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
                    partner: '',
                    delivery_dt: '',
                },
                partners: '' //Список партнеров
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
        },
        components: {datetime}
    }
</script>