<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials';
    protected $fillable = [
        'name', 'task', 'note', 'location_id', 'batch_id', 'user_id', 'status'
    ];

    public function location(): HasOne
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    public function batch(): HasOne
    {
        return $this->hasOne(Batch::class, 'id', 'batch_id');
    }
}
