<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';
    protected $fillable = ['transaction_id', 'installment', 'start_date', 'end_date', 'nominal', 'payment_proof', 'status'];
    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }
}
