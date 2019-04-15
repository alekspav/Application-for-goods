<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status', 'client_email', 'partner_id', 'delivery_dt'
    ];


    public function partner()
    {
        return $this->belongsTo('App\Partner');
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
