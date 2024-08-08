<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    protected $fillable = [
        'datetime',
        'patient_id',
        'doctor_id',
    ];

    public function patients()
    {
        return $this->belongsTo(Patient::class,'patient_id');
    }


    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}
