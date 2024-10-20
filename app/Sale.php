<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'price',
        'sale_date',
        'total'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
