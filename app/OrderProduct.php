<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'quantity'
    ];

    /**
     * Поставщики
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Ссылка на App\Vendor
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }

}
