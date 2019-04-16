<template>
    <div>
        <div class="form-group">
            <router-link to="/" class="btn btn-default">Назад</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Создать продукт</div>
            <div class="panel-body">
                <form v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Наименование</label>
                            <input type="text" v-model="product.name" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Поставщик</label>
                            <select v-model="product.vendor_id" class="form-control">
                                <option v-for="vendor in vendors" v-bind:value="vendor.id">{{vendor.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            <label class="control-label">Цена</label>
                            <input type="number" v-model="product.price" class="form-control">
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
                product: {
                    name: '',
                    vendor_id: null,
                    price: null,
                },
                vendors: '' //Список партнеров
            }
        },
        mounted() {
            let app = this;
            //Получает партнеров
            axios.get('/api/vendors')
                .then(function (resp) {
                    app.vendors = resp.data;
                })
                .catch(function () {
                    alert("Нельзя загрузить поставщиков")
                });
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newVendor = app.vendor;
                axios.post('/api/vendors', newOrder)
                    .then(function (resp) {
                        app.$router.push({path: '/products'});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Невозможно создать продукт");
                    });
            }
        }
    }
</script>