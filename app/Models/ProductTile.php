<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTile extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title',
        'description',
    ];


    public function productData()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

}
