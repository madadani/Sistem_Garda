<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanLog extends Model
{
    use HasFactory;

    protected $table = 'scan_logs';

    protected $fillable = [
        'driver_id',
        'patient_id',
        'scan_time',
        'status',
    ];

    protected $casts = [
        'scan_time' => 'datetime',
    ];

    /**
     * Relasi ke Driver
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Relasi ke Patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
