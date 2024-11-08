<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_category_id',
        'top_banner_title',
        'top_banner_description',
        'top_banner_image',
    ];

    public function bannerCategoryData()
    {
        return $this->belongsTo(BannerCategory::class,'banner_category_id');
    }

}
