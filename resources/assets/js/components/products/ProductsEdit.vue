<template>
    <div>
        <div class="form-group">
            <router-link :to="{ name: 'indexProduct'}" class="btn btn-default">Назад</router-link>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">Обновить продукт</div>
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
                            <button class="btn btn-success">Обновить</button>
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
                vendors: '', //Список партнеров,
                productId: null //Идентификатор продукта
            }
        },
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.productId = id;

            //Получает заказ с иденьтификатором
            axios.get('/api/products/' + id)
                .then(function (resp) {
                    app.product = resp.data;
                })
                .catch(function () {
                    alert("Нельзя загрузить продукт")
                });


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
                var newProduct = app.product;
                axios.patch('/api/products/' + app.productId, newProduct)
                    .then(function (resp) {
                        app.$router.replace('/products');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Нельзя создать продукт");
                    });
            }
        }
    }
</script>