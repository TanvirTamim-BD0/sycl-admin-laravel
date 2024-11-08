<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'color',
        'size',
        'qty',
        'price',
    ];


    public function orderData()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function productData()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

}
