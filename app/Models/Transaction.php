<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';
    protected $fillable = ['student_id', 'installment', 'total_price', 'ongoing_installment', 'status'];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'transaction_id', 'id');
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'id', 'student_id');
    }
}
