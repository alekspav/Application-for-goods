<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default weather-panel">
                    <div class="panel-heading"><h2>Температура в Брянске</h2></div>

                    <div class="panel-body">

                        <div id="weather">
                            <span class="temperature">Сейчас {{currentTemp}}° </span>


                            <div class="weather-daytime">
                                <span id="temp-u"> Утром [{{minUTemp}}° .. {{maxUTemp}}°]</span><br>
                                <span id="temp-d"> Днем [{{minDTemp}}° .. {{maxDTemp}}°]</span><br>
                                <span id="temp-v"> Вечером [{{minVTemp}}° .. {{maxVTemp}}°]</span><br>
                                <span id="temp-n"> Ночью [{{minNTemp}}° .. {{maxNTemp}}°]</span><br>
                                <span id="temp-nu"> После полуночи [{{minNUTemp}}° .. {{maxNUTemp}}°]</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                //В наст время
                currentTemp: '',

                //утром
                minUTemp: '',
                maxUTemp: '',

                //Днем
                minDTemp: '',
                maxDTemp: '',

                //Вечером
                minVTemp: '',
                maxVTemp: '',

                //Ночью
                minNTemp: '',
                maxNTemp: '',

                //Ночью утром
                minNUTemp: '',
                maxNUtemp: ''
            }
        },
        methods: {
            /**
             * Парсить XML
             *
             * @this  {VueComponent}
             * @param {string} xml - XML-строка.
             */
            doParseXML(xml) {
                var parseString = require('xml2js').parseString;
                self = this;
                parseString(xml, function (err, parsed_object) {
                    //Время дня
                    let daytime = parsed_object.info.weather[0].day[0].daytime[0];//Возможные значения  - u,d,v,n
                    let day_times = ['u', 'd', 'v', 'n'];
                    let time_index = day_times.indexOf(daytime);
                    time_index = time_index == -1 ? 4 : time_index;//Поправка утром ночью

                    //Время дня
                    let day_part = parsed_object.info.weather[0].day[0].day_part[time_index];

                    //Объект температуры в настоящее время
                    let temp_obj;

                    //В настоящее время
                    if (daytime == "u") {
                        temp_obj = day_part.temperature;
                        self.currentTemp = temp_obj[0]['_'];

                    }
                    else {
                        self.currentTemp = day_part.temperature_to[0]['_'];
                    }

                    //утром
                    self.minUTemp = parsed_object.info.weather[0].day[0].day_part[4].temperature_to[0]['_'];
                    self.maxUTemp = parsed_object.info.weather[0].day[0].day_part[0].temperature[0]['_'];

                    //Днем
                    self.minDTemp = parsed_object.info.weather[0].day[0].day_part[1].temperature_from[0]['_'];
                    self.maxDTemp = parsed_object.info.weather[0].day[0].day_part[1].temperature_to[0]['_'];

                    //Вечером
                    self.minVTemp = parsed_object.info.weather[0].day[0].day_part[2].temperature_from[0]['_'];
                    self.maxVTemp = parsed_object.info.weather[0].day[0].day_part[2].temperature_to[0]['_'];

                    //Ночью
                    self.minNTemp = parsed_object.info.weather[0].day[0].day_part[3].temperature_from[0]['_'];
                    self.maxNTemp = parsed_object.info.weather[0].day[0].day_part[3].temperature_to[0]['_'];

                    //Ночью утром
                    self.minNUTemp = parsed_object.info.weather[0].day[0].day_part[4].temperature_from[0]['_'];
                    self.maxNUTemp = parsed_object.info.weather[0].day[0].day_part[4].temperature_to[0]['_'];

                });
            },

            /**
             * Получить погоду
             *
             * @this  {VueComponent}
             */
            getWeather() {
                let url = "api/weather/191";

                axios({'url': url})
                    .then(response => {
                        this.doParseXML(response.data);
                    })

                    .catch(error => {
                        console.log(error);
                    });

            },
        },
        created() {
            this.getWeather();
        }
    }
</script>
<style scoped>
    .weather-panel {
        font-family: 'Vast Shadow', cursive;
    }

    .panel-heading {
        background: red;
    }

    .panel-body {
        background: greenyellow;
    }

    #weather {
        padding: 15px;
        vertical-align: middle;

    }

    .temperature {
        font-size: 40px;
    }


</style>
