<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $fillable = ['name', 'email', 'location_id', 'batch_id', 'address', 'phone_number', 'ktp_file', 'ijazah_file', 'status'];

    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function batch(): HasOne
    {
        return $this->hasOne(Batch::class, 'id', 'batch_id');
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'student_id', 'id');
    }
}
