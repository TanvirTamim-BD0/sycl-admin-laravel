<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiddleCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'middle_category_name',
    ];

    public function categoryData()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function subCategoryData()
    {
        return $this->hasMany(SubCategory::class,'middle_category_id');
    }


}
