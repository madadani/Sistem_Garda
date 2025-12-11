<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'driver_id_card',
        'name',
        'phone_number',
        'instansi',
        'total_points',
        'points_redeemed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_points' => 'integer',
        'points_redeemed' => 'integer',
    ];
    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }
    /**
     * Relasi ke Transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get total confirmed transactions
     */
    public function getTotalConfirmedTransactionsAttribute()
    {
        return $this->transactions()->where('status', 'CONFIRMED')->count();
    }
}
