<template>
    <div>
        <h2>Заказы</h2>
        <div class="form-group">
            <router-link :to="{name: 'createOrder', params: {parentRoute: 'indexOrder'}}" class="btn btn-success">Создать новый заказ</router-link>
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
                            <router-link :to="{name: 'editOrder', params: {id: order.id, parentRoute: 'indexOrder'}}"
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
                <div class="pagination">
                    <button :disabled="! prevPage" @click.prevent="goToPrev">Предыдущий</button>
                    {{ paginatonCount }}
                    <button :disabled="! nextPage" @click.prevent="goToNext">Следующий</button>
                </div>
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
    const getOrders = (page, callback) => {
        const params = {page};

        axios
            .get('/api/orders', {params})
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
        data: function () {
            return {
                orders: [],
                meta: null,

                //Объект для pagination
                links: {
                    first: null,
                    last: null,
                    next: null,
                    prev: null,
                },
                error: null,
            }
        },
        computed: {
            /**
             * Какая следующая страница
             * @returns {integer}
             */
            nextPage() {
                if (!this.meta || this.meta.current_page === this.meta.last_page) {
                    return;
                }

                return this.meta.current_page + 1;
            },
            /**
             * Какая предыдущая страница
             * @returns {integer}
             */
            prevPage() {
                if (!this.meta || this.meta.current_page === 1) {
                    return;
                }

                return this.meta.current_page - 1;
            },
            //Текст между кнопками
            paginatonCount() {
                if (!this.meta) {
                    return;
                }

                const {current_page, last_page} = this.meta;

                return `${current_page} из ${last_page}`;
            },
        },
        //До подтверждения пути, соответствующему этому компоненту
        //this создасться не успел
        beforeRouteEnter(to, from, next) {
            getOrders(to.query.page, (err, data) => {
                next(vm => vm.setData(err, data));
            });
        },
        //Когда поменялся маршрут, но он соответствует этому же компоненту
        //Этот компонент будет использоваться повторно
        beforeRouteUpdate(to, from, next) {
            this.users = this.links = this.meta = null;
            getOrders(to.query.page, (err, data) => {
                this.setData(err, data);
                next();
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
            goToNext() {
                this.$router.push({
                    query: {
                        page: this.nextPage,
                    },
                });
            },
            goToPrev() {
                this.$router.push({
                    name: 'indexProduct',
                    query: {
                        page: this.prevPage,
                    }
                });
            },
            //установка данных
            setData(err, {data: orders, links, meta}) {
                if (err) {
                    this.error = err.toString();
                } else {
                    this.orders = orders;
                    this.links = links;
                    this.meta = meta;
                }
            }
        },


    }

</script>