<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'rating_value',
        'user_id',
        'comment'
    ];
    public function ad(){
        return $this->belongsTo(Ad::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
