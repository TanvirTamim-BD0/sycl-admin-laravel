<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BottomBannner extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_category_id',
        'bottom_banner_image',
        'bottom_banner_text_1',
        'bottom_banner_text_2',
        'bottom_banner_text_3',
    ];

    public function bannerCategoryData()
    {
        return $this->belongsTo(BannerCategory::class,'banner_category_id');
    }

}
