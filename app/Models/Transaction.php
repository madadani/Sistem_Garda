<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'driver_id',
        'status',
        'scan_time',
        'points_awarded',
        'confirmed_by_admin_id',
    ];

    protected $casts = [
        'scan_time' => 'datetime',
        'points_awarded' => 'integer',
    ];

    /**
     * Relasi ke Driver
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Relasi ke Admin yang konfirmasi
     */
    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by_admin_id');
    }

    /**
     * Relasi ke Patient
     */
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    /**
     * Scope untuk filter pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'PENDING');
    }

    /**
     * Scope untuk filter confirmed
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'CONFIRMED');
    }

    /**
     * Scope untuk filter rejected
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'REJECTED');
    }
}
