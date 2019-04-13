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
     * @return string JSON Результат
     */
    public function show($id){
        $url = "https://export.yandex.ru/bar/reginfo.xml?region=".$id;
        $jsonData = json_decode(file_get_contents($url));
        return $jsonData;
    }

}
