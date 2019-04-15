<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default weather-panel">
                    <div class="panel-heading"><span>Температура в Брянске</span><span
                            class="pull-right">Яндекс.Погода</span></div>

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
             * Получить температуру
             *
             * @this  {VueComponent}
             * @param {Object} day_part - Объект, представляющий часть дня
             * @param {Object} to - Свойство объект
             *
             * @return {Object} Новый объект температуры.
             */
            getTemperature(day_part, to = 'temperature') {
                if (to in day_part) {
                    return day_part[to];
                }
                else {
                    return day_part['temperature']
                }
            },

            /**
             * Парсить XML
             *
             * @this  {VueComponent}
             * @param {string} xml - XML-строка.
             *
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

                    //Температура в настоящее время
                    self.currentTemp = self.getTemperature(day_part, 'temperature_to')[0]['_'];

                    //утром
                    self.minUTemp = self.getTemperature(parsed_object.info.weather[0].day[0].day_part[4], 'temperature_to')[0]['_'];
                    self.maxUTemp = self.getTemperature(parsed_object.info.weather[0].day[0].day_part[0], 'temperature')[0]['_'];

                    //Днем
                    self.minDTemp = self.getTemperature(parsed_object.info.weather[0].day[0].day_part[1], 'temperature_from')[0]['_'];
                    self.maxDTemp = self.getTemperature(parsed_object.info.weather[0].day[0].day_part[1], 'temperature_to')[0]['_'];

                    //Вечером
                    self.minVTemp = self.getTemperature(parsed_object.info.weather[0].day[0].day_part[2], 'temperature_from')[0]['_'];
                    self.maxVTemp = self.getTemperature(parsed_object.info.weather[0].day[0].day_part[2], 'temperature_to')[0]['_'];

                    //Ночью
                    self.minNTemp = self.getTemperature(parsed_object.info.weather[0].day[0].day_part[3], 'temperature_from')[0]['_'];
                    self.maxNTemp = self.getTemperature(parsed_object.info.weather[0].day[0].day_part[3], 'temperature_to')[0]['_'];

                    //Ночью утром
                    self.minNUTemp = self.getTemperature(parsed_object.info.weather[0].day[0].day_part[4], 'temperature_from')[0]['_'];
                    self.maxNUTemp = self.getTemperature(parsed_object.info.weather[0].day[0].day_part[4], 'temperature_to')[0]['_'];

                });
            }
            ,

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

            }
            ,
        },
        created() {
            this.getWeather();
        }
    }
</script>
