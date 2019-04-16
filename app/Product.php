<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'vendor_id'
    ];


    /**
     * Поставщики
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Ссылка на App\Vendor
     */
    public function vendor()
    {
        return $this->belongsTo('App\Venor');
    }
}
