<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductQuantity extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_name',
        'size_name',
        'quantity',
    ];

    public function productData()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

}
