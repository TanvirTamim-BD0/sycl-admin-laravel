<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_unique_id',
        'customer_id',
        'address_id',
        'subtotal_amount',
        'shipping_fee',
        'total_amount',
        'access_code',
        'delivery_time',
        'payment_status',
        'order_status',
        'delivery_status',
    ];

    public function orderProductData()
    {
        return $this->hasMany(OrderProduct::class,'order_id');
    }

    public function customerData()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public static function getAllImageProductIdWise($productId,$colorId)
    {
        $data = ProductColorManage::where('product_id', $productId)->where('color_name',$colorId)->first();
        $images = json_decode($data->product_images);

        $getImageData = [];
        foreach($images as $key => $item){
            if($item != null){
                $getImageData[] = $item;
            }
        }

        return $getImageData;

    }

}
