<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColorManage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_name',
        'color_code',
        'product_price',
        'product_size',
        'product_images',
    ];


    public function productData()
    {
        return $this->belongsTo(Product::class,'product_id');
    }


    //To get all the size data  wise...
    public static function getAllSizeDataProductIdWise($colorId)
    {
        $data = ProductColorManage::where('id', $colorId)->first();

        if ($data->product_size != 'null') {
            $sizeIds = json_decode($data->product_size);

            $getSizeData = [];
            foreach($sizeIds as $key => $item){
                if($item != null){
                    $getSizeData[] = Size::where('size_name', $item)->first();
                }
            }

            return $getSizeData;
        }else{
            $getSizeData = [];
            return $getSizeData;
        }   
    }


    public static function getAllImageProductIdWise($colorId)
    {
        $data = ProductColorManage::where('id', $colorId)->first();
        $images = json_decode($data->product_images);

        $getImageData = [];
        foreach($images as $key => $item){
            if($item != null){
                $getImageData[] = $item;
            }
        }

        return $getImageData;
    }


    public static function getAllColorDataProductIdWise($productId)
    {
        $data = ProductColorManage::where('product_id', $productId)->get();
        return $data;
    }


    public static function getSingleColorData($productId)
    {
        $data = ProductColorManage::where('product_id', $productId)->first();
        return $data;
    }
    
}
