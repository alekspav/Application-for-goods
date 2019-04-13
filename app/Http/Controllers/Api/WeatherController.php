<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WeatherController extends Controller
{
    /**
     * Возвращет JSON-погоды
     *
     * @param $id Идентификатор города
     *
     * @return string XML Результат
     */
    public function get_weather($id)
    {
        //Получаем XML c API
        $url = "https://export.yandex.ru/bar/reginfo.xml?region=" . $id;
        header('Content-type: application/xml');
        $xmlData = file_get_contents($url);

        return $xmlData;
    }

}
