<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'first_name',
        'last_name',
        'mobile_number',
        'country_id',
        'city_id',
        'post_code',
        'university_id',
        'address_type',
        'address',
        'active_status',
    ];

    public function countryData()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function cityData()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function universityData()
    {
        return $this->belongsTo(University::class,'university_id');
    }

}
