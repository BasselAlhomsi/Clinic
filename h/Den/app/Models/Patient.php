<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'age',
        'email',
    ];

    
    public function dates()
    {
        return $this->hasmany(Date::class);
    }
}
