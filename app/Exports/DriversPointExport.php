<?php

namespace App\Exports;

use App\Models\Driver;
use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DriversPointExport implements FromCollection, WithHeadings, WithMapping
{
    protected $driverIds;
    protected $customCollection;

    public function __construct($driverIds = null)
    {
        $this->driverIds = $driverIds;
        $this->customCollection = null;
    }

    public function setCollection($collection)
    {
        $this->customCollection = $collection;
        return $this;
    }

    public function collection()
    {
        if ($this->customCollection) {
            return $this->customCollection;
        }

        if ($this->driverIds) {
            // Handle single driver ID or array of driver IDs
            $driverIdArray = is_array($this->driverIds) ? $this->driverIds : [$this->driverIds];
            
            // Ambil data driver dengan semua transaksi dan pasien yang dibawa
            $drivers = Driver::with(['transactions.patient'])
                            ->whereIn('id', $driverIdArray)
                            ->get();
            
            $exportData = [];
            
            foreach ($drivers as $driver) {
                // Tambahkan informasi driver di baris pertama
                $exportData[] = [
                    'type' => 'driver_info',
                    'driver_id_card' => $driver->driver_id_card,
                    'name' => $driver->name,
                    'instansi' => $driver->instansi,
                    'total_points' => $driver->total_points,
                    'patient_name' => '',
                    'patient_medical_record' => '',
                    'scan_time' => '',
                    'points_awarded' => '',
                    'status' => '',
                    'transaction_id' => ''
                ];

                // Tambahkan data pasien yang dibawa
                foreach ($driver->transactions as $transaction) {
                    if ($transaction->patient) {
                        $exportData[] = [
                            'type' => 'patient_data',
                            'driver_id_card' => $driver->driver_id_card, // Tetap tampilkan ID driver di setiap baris pasien
                            'name' => $driver->name, // Tetap tampilkan nama driver
                            'instansi' => $driver->instansi,
                            'total_points' => '', // Kosongkan untuk baris pasien
                            'transaction_id' => $transaction->transaction_id ?? '-',
                            'patient_name' => $transaction->patient->patient_name ?? '-',
                            'patient_condition' => $transaction->patient->patient_condition ?? '-',
                            'destination' => $transaction->patient->destination ?? '-',
                            'arrival_time' => $transaction->patient->arrival_time ? $transaction->patient->arrival_time->format('d/m/Y H:i') : '-',
                            'scan_time' => $transaction->scan_time ? $transaction->scan_time->format('d-m-Y H:i') : '-',
                            'points_awarded' => $transaction->points_awarded ?? 0,
                            'status' => $transaction->status ?? '-'
                        ];
                    }
                }
            }

            return collect($exportData);
        }
        
        // Untuk export semua driver (format sederhana)
        return Driver::select('driver_id_card', 'name', 'instansi', 'total_points', 'created_at')->get();
    }

    public function map($item): array
    {
        if ($this->customCollection) {
            // Untuk custom collection (format sederhana)
            return [
                $item->driver_id_card,
                $item->name,
                $item->instansi,
                $item->total_points,
                $item->created_at ? $item->created_at->format('d-m-Y') : ''
            ];
        }

        if ($this->driverIds && isset($item['type'])) {
            if ($item['type'] === 'driver_info') {
                // Baris driver info - hanya tampilkan kolom driver
                return [
                    $item['driver_id_card'],
                    $item['name'],
                    $item['instansi'],
                    $item['total_points'],
                    '', // Kosongkan nama pasien untuk baris driver
                    '', // Kosongkan keluhan untuk baris driver
                    '', // Kosongkan tujuan untuk baris driver
                    ''  // Kosongkan waktu kedatangan untuk baris driver
                ];
            } else {
                // Baris pasien - tampilkan data pasien dengan ID driver
                return [
                    '', // Kosongkan ID driver untuk baris pasien
                    '', // Kosongkan nama driver untuk baris pasien
                    '', // Kosongkan instansi untuk baris pasien
                    '', // Kosongkan total points untuk baris pasien
                    $item['patient_name'],
                    $item['patient_condition'],
                    $item['destination'],
                    $item['arrival_time']
                ];
            }
        }

        // Untuk export semua driver (format sederhana - hanya 4 kolom)
        return [
            $item->driver_id_card,
            $item->name,
            $item->instansi,
            $item->total_points,
            $item->created_at ? $item->created_at->format('d-m-Y') : ''
        ];
    }

    public function headings(): array
    {
        if ($this->customCollection) {
            // Untuk custom collection (format sederhana)
            return [
                'ID Card Driver',
                'Nama Driver',
                'Instansi',
                'Total Poin',
                'Tanggal'
            ];
        }

        if ($this->driverIds) {
            // Untuk export driver spesifik (format sesuai permintaan)
            return [
                'ID Driver',
                'Nama Driver',
                'Instansi',
                'Total Poin',
                'Nama Pasien',
                'Keluhan',
                'Tujuan',
                'Waktu Kedatangan'
            ];
        } else {
            // Untuk export semua driver (format sederhana)
            return [
                'ID Card Driver',
                'Nama Driver',
                'Instansi',
                'Total Poin',
                'Tanggal'
            ];
        }
    }
}
