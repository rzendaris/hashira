<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentReport extends Model
{
    use HasFactory;

    protected $table = 'student_report';
    protected $fillable = ['student_id', 'material_id', 'score', 'status'];

    public function material(): HasOne
    {
        return $this->hasOne(Material::class, 'id', 'material_id');
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }
}
