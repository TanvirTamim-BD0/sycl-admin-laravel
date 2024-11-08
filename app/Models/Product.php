<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id',
        'banner_category_id',
        'product_name',
        'product_keyword',
        'product_video',
        'status',
    ];

    public function subCategoryData()
    {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    public function bannerCategoryData()
    {
        return $this->belongsTo(BannerCategory::class,'banner_category_id');
    }

    public function colorData()
    {
        return $this->hasMany(ProductColorManage::class,'product_id');
    }

    public function productTile()
    {
        return $this->hasMany(ProductTile::class,'product_id');
    }

    public function productQuantity()
    {
        return $this->hasMany(ProductQuantity::class,'product_id');
    }
    


     //get sub cateroy data product id wise ......
     public static function getSubCategoryDataProductIdWise($productId)
     {
         $data = Product::where('id', $productId)->first();
         $subCategoryIds = json_decode($data->sub_category_id);
 
         $getSubCategoryData = [];
         foreach($subCategoryIds as $key => $item){
             if($item != null){
                 $getSubCategoryData[] = SubCategory::where('id', $item)->first();
             }
         }
 
         return $getSubCategoryData;
 
     }


     //get keyword data product id wise ......
     public static function getKeywordDataProductIdWise($productId)
     {
         $data = Product::where('id', $productId)->first();
         $keywordIds = json_decode($data->product_keyword);
        
         $getkeywordData = [];
         foreach($keywordIds as $key => $item){
             if($item != null){
                 $getkeywordData[] = ProductKeyword::where('id', $item)->first();
             }
         }

         return $getkeywordData;
     }



}
