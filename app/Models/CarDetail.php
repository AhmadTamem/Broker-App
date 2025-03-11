<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'car_condition',
        'make',
        'vehicle_class',
        'transmission',
        'manufacturing_year',
        'kilometers',
        'color',
        'fuel',
        'engine_capacity',
        'seller_type',
        'ad_id'
    ];
    public function ad(){
        return $this->belongsTo(Ad::class);
    }
}
