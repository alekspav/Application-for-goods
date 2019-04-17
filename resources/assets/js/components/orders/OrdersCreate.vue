<template>
    <div>
        <div class="form-group">
            <router-link :to="{name: parentRoute}" class="btn btn-default">Назад</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Создать заказ</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Статус</label>
                            <select  required class="form-control" v-model="order.status">
                                <option value="0">Новый</option>
                                <option value="10">Подтвержден</option>
                                <option value="20">Завершен</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Почта клиента</label>
                            <input required type="text" v-model="order.client_email" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Партнер</label>
                            <select required v-model="order.partner_id" class="form-control">
                                <option v-for="partner in partners" v-bind:value="partner.id">{{partner.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Доставлено</label>
                            <datetime required format="YYYY-MM-DD h:i:s" width="300px" v-model="order.delivery_dt"></datetime>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <button class="btn btn-success">Создать</button>
                        </div>
                    </div>
                </form>
                <p class="text-info">
                    Добавление продуктов в заказ возможно после создания заказа
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import datetime from 'vuejs-datetimepicker';

    export default {
        props: ['parentRoute'], //Родительский маршрут для корректного обратного перехода
        data: function () {
            return {
                order: {
                    status: '',
                    client_email: '',
                    partner_id: '',
                    delivery_dt: '',
                },
                partners: '', //Список партнеров
            }
        },
        mounted() {
            let app = this;
            //Получает партнеров
            axios.get('/api/partners')
                .then(function (resp) {
                    app.partners = resp.data;
                })
                .catch(function () {
                    alert("Нельзя загрузить партнеров")
                });
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newOrder = app.order;
                axios.post('/api/orders', newOrder)
                    .then(function (resp) {
                        app.$router.push({name: app.parentRoute});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Невозможно создать заказ");
                    });
            }
        },
        components: {datetime}
    }
</script>