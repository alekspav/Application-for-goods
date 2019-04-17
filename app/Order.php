<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = [
        'status', 'client_email', 'partner_id', 'delivery_dt'
    ];

    protected $appends = array('status_name');

    /**
     * Партнеры
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Ссылка на App\Partner
     */
    public function partner()
    {
        return $this->belongsTo('App\Partner');
    }


    /**
     * @return string Получить имя статуса
     */
    public function getStatusNameAttribute(){
        if($this->status == 0){
            return "Новый";
        }
        else if($this->status == 10){
            return "Подтвержден";
        }
        else if($this->status == 20){
            return "Завершен";
        }

        return "Не определен";
    }


    /**
     * 'Просроченная' область видимости
     *
     * @param $query Запрос
     * @return mixed Модифицированный запрос
     */
    public function scopeBack($query)
    {
        return $query->where('delivery_dt', '<', date('Y-m-d').' 00:00:00')->where('status', 10)->take(50)->orderBy('delivery_dt', 'desc');
    }


    /**
     * 'Текущая' область видимости
     *
     * @param $query Запрос
     * @return mixed Модифицированный запрос
     */
    public function scopeActual($query)
    {
        return $query->where('status', 10)->where('delivery_dt', '>',Carbon::parse('-24 hours'))->orderBy('delivery_dt', 'asc');
    }

    /**
     * 'Новые' область видимости
     *
     * @param $query Запрос
     * @return mixed Модифицированный запрос
     */
    public function scopeNew($query)
    {
        return $query->where('status', 0)->where('delivery_dt', '>', date('Y-m-d').' 00:00:00')->take(50)->orderBy('delivery_dt', 'asc');
    }


    /**
     * 'Success' область видимости
     *
     * @param $query Запрос
     * @return mixed Модифицированный запрос
     */
    public function scopeSuccess($query)
    {
        return $query->where('status', 20)->where('delivery_dt', '>',Carbon::parse('-24 hours'))->take(50)->orderBy('delivery_dt', 'desc');
    }



}
