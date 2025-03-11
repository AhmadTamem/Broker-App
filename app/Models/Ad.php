<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'price',
        'location',
        'category_id',
        'offer_type',
        'type_ad',
        'views',
        'status'

    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function image(){
        return $this->hasMany(Image::class);
    }
    public function rating(){
        return $this->hasMany(Rating::class);
    }
    public function carDetail(){
        return $this->hasOne(CarDetail::class);
    }
    public function propertyDetail(){
        return $this->hasOne(PropertyDetail::class);
    }
}
