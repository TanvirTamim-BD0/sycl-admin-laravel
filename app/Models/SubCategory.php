<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'middle_category_id',
        'sub_category_name',
        'sub_category_image',
    ];


    public function middleCategoryData()
    {
        return $this->belongsTo(MiddleCategory::class,'middle_category_id');
    }

}
