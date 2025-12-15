<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewScan implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $scanData;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $scan;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Transaction $scan
     * @return void
     */
    public function __construct($scan)
    {
        $this->scan = $scan;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('scans');
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'new-scan';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        // Gunakan logic yang sama dengan ScanController untuk konsistensi
        $today = today();
        $yesterday = today()->subDay();
        
        $scansToday = \App\Models\Transaction::whereDate('scan_time', $today)
            ->where('status', 'CONFIRMED')
            ->whereHas('patient', function($q) {
                $q->whereNotNull('patient_name')
                  ->where('patient_name', '!=', '')
                  ->whereNotNull('patient_condition')
                  ->where('patient_condition', '!=', '');
            })->count();
            
        $scansYesterday = \App\Models\Transaction::whereDate('scan_time', $yesterday)
            ->where('status', 'CONFIRMED')
            ->whereHas('patient', function($q) {
                $q->whereNotNull('patient_name')
                  ->where('patient_name', '!=', '')
                  ->whereNotNull('patient_condition')
                  ->where('patient_condition', '!=', '');
            })->count();
        
        return [
            'scan' => [
                'id' => $this->scan->id,
                'driver_name' => $this->scan->driver->name,
                'scan_time' => $this->scan->scan_time->format('H:i'),
                'points' => $this->scan->points_awarded,
                'status' => $this->scan->status,
                'created_at' => $this->scan->created_at->toDateTimeString()
            ],
            'scans_today' => $scansToday,
            'scans_yesterday' => $scansYesterday,
            'increment' => 1
        ];
    }
}
