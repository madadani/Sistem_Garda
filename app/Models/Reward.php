<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'points_spent',
        'convert_point',
        'remaining_points',
        'status',
    ];

    protected $casts = [
        'points_spent' => 'integer',
    ];

    const POINT_VALUE = 50000;

    /**
     * Relasi ke Driver
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Hitung nilai reward berdasarkan poin
     * 1 point = Rp 50.000
     */
    public function getRewardValueAttribute()
    {
        return $this->points_spent * 50000;
    }

    /**
     * Format nilai reward dalam Rupiah
     */
    public function getFormattedRewardValueAttribute()
    {
        return 'Rp ' . number_format($this->reward_value, 0, ',', '.');
    }
}
