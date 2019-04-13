<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Температура в Брянске</div>

                    <div class="panel-body">
                        <div id="weather">
                            {{getTemp}}
                        </div>
                        <div id="weather-for-check">
                            <p>Для проверки</p>
                            <a href="https://clck.yandex.ru/redir/dtype=stred/pid=7/cid=1228/*https://yandex.ru/pogoda/191"
                               target="_blank"><img src="https://info.weather.yandex.net/191/1_white.ru.png?domain=ru"
                                                    border="0" alt="Яндекс.Погода"/><img width="1" height="1"
                                                                                         src="https://clck.yandex.ru/click/dtype=stred/pid=7/cid=1227/*https://img.yandex.ru/i/pix.gif"
                                                                                         alt="" border="0"/></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueJsonp from 'vue-jsonp';
    Vue.use(VueJsonp)
    Vue.use(VueJsonp, 5000)

    export default {
        data: function() {
            return  {
                getTemp: ''
            }
        },
        methods: {
            getWeather() {
               let url = "api/weather/191";

                axios({'url': url})
                    .then(response => {
                        this.getTemp = response.data;
                        console.log(response);
                    })

                    .catch(error => {
                        console.log(error);
                    });

            },
        },
        beforeMount() {
            this.getWeather();
        },

    }
</script>
