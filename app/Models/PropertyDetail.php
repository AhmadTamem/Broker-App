<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'area',
        'floor_number',
        'type_of_ownership',
        'number_of_rooms',
        'seller_type',
        'furnishing',
        'direction',
        'condition',
        'ad_id'
    ];
    public function ad(){
        return $this->belongsTo(Ad::class);
    }
}
