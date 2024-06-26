<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = [
        'name', 'email', 'location_id', 'batch_id', 'teacher_id', 'gender', 'birth_date', 'education', 'city', 'address', 'phone_number', 'ktp_file', 'ijazah_file', 'program', 'ssw_status', 'jft_status', 'status'
    ];

    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function batch(): HasOne
    {
        return $this->hasOne(Batch::class, 'id', 'batch_id');
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'teacher_id');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'student_id', 'id');
    }

    public function report(): HasMany
    {
        return $this->hasMany(StudentReport::class, 'student_id', 'id');
    }
}
