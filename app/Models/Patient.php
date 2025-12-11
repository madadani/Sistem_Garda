<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'patient_name',
        'patient_condition',
        'destination',
        'arrival_time',
    ];

    protected $casts = [
        'arrival_time' => 'datetime',
    ];

    /**
     * Relasi ke Transaction
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
