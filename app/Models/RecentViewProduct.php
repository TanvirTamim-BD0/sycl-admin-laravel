<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentViewProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'customer_id',
    ];

    public function productData()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function colorData()
    {
        return $this->hasMany(ProductColorManage::class,'product_id','product_id');
    }
    
}
