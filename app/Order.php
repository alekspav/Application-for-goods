<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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



    public function getDate()
    {
        return $this->created_at;
    }

    public function getData()
    {
        $key = 'data';
        if (!isset($this->dynamic[$key])) {
            $this->dynamic[$key] = json_decode($this->data);
        }
        return (array)$this->dynamic[$key];
    }

    public function getSum()
    {
        $sum = 0;
        $items = $this->getData();
        foreach ($items as $item) {
            $sum += ($item->cost * $item->count);
        }
        return round($sum, 2);
    }

}
