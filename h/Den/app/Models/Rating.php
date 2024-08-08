<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'description',
        'date_id',
    ];

    public function date()
    {
        return $this->belongsTo(Date::class,'date_id');
    }

}
