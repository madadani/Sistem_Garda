<?php

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ScanCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $transaction_id;
    public string $transaction_code;
    public string $driver_name;
    public string $driver_id_card;
    public string $scan_time;
    public int $points_awarded;
    public int $pending_count;

    public function __construct(Transaction $transaction, int $pendingCount)
    {
        $this->transaction_id   = $transaction->id;
        $this->transaction_code = $transaction->transaction_id;
        $this->driver_name      = $transaction->driver->name ?? '';
        $this->driver_id_card   = $transaction->driver->driver_id_card ?? '';
        $this->scan_time        = optional($transaction->scan_time)->format('d/m/Y H:i') ?? '';
        $this->points_awarded   = (int) $transaction->points_awarded;
        $this->pending_count    = $pendingCount;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('scan-notifications');
    }

    public function broadcastAs(): string
    {
        return 'ScanCreated';
    }
}
