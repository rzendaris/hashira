<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PotentialStudent extends Model
{
    use HasFactory;

    protected $table = 'potential-students';
    protected $fillable = [
        'name', 'email', 'gender', 'birth_date', 'education', 'city', 'address', 'phone_number', 'status'
    ];

}
