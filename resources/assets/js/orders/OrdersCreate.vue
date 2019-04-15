<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Назад</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Создать заказ</div>
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
        data: function () {
            return {
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
                axios.post('/api/orders', newOrder)
                    .then(function (resp) {
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Невозможно создать заказ");
                    });
            }
        }
    }
</script>