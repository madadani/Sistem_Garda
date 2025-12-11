<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DriverPointsUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $driver_id;
    public int $total_points;
    public int $remaining_points;

    public function __construct(int $driverId, int $totalPoints, int $remainingPoints)
    {
        $this->driver_id = $driverId;
        $this->total_points = $totalPoints;
        $this->remaining_points = $remainingPoints;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('driver-points');
    }

    public function broadcastAs(): string
    {
        return 'DriverPointsUpdated';
    }
}
