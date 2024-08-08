<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{


    use HasFactory;
    protected $fillable = [
        'condition_name',
        'test',
        'drugs',
        'date_id',
    ];

     public function date()
    {
        return $this->belongsTo(Date::class);
    }
}
