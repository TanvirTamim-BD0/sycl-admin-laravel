<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SquareBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_category_id',
        'square_banner_title',
        'square_banner_description',
        'square_banner_image',
    ];


    public function bannerCategoryData()
    {
        return $this->belongsTo(BannerCategory::class,'banner_category_id');
    }
    
}
