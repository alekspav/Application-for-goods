<template>
    <div>
        <h1>Заказы по категориям</h1>
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#panel1">Текущие</a></li>
            <li><a data-toggle="tab" href="#panel2">Просроченные</a></li>
            <li><a data-toggle="tab" href="#panel3">Новые</a></li>
            <li><a data-toggle="tab" href="#panel4">Выполненные</a></li>

        </ul>

        <div class="tab-content">
            <div id="panel1" class="tab-pane fade in active">
                <h3>Текущие</h3>
                <scoped_orders :scopeType="1"></scoped_orders>
            </div>
            <div id="panel2"  class="tab-pane fade">
                <h3>Просроченные</h3>
                <scoped_orders :scopeType="0"></scoped_orders>
            </div>
            <div id="panel3" class="tab-pane fade">
                <h3>Новые</h3>
                <scoped_orders :scopeType="2"></scoped_orders>
            </div>
            <div id="panel4" class="tab-pane fade">
                <h3>Выполненные</h3>
                <scoped_orders :scopeType="3"></scoped_orders>
            </div>
        </div>
    </div>
</template>

<script>
    import scoped_orders from './ScopedOrdersIndex.vue';

    export default {
        name: "OrderTabsIndex",
        components:{
            scoped_orders
        }
    }
</script>

<style scoped>

</style>