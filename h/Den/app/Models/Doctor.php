<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'age',
        'email',
        'specialization_id',
    ];


    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
    public function dates()
    {
        return $this->hasMany(Date::class);
    }
}
