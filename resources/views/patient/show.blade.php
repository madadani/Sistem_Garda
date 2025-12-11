@extends('layouts.app')

@section('title', 'Detail Pasien')
@section('page-title', 'Detail Pasien')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('patient.index') }}" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Pasien
        </a>
    </div>

    <!-- Patient Info Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-primary-600 to-purple-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white">Detail Pasien</h2>
        </div>

        <div class="p-6 space-y-6">
            <!-- Patient Information -->
            <div class="space-y-4">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Nama Pasien</h3>
                        <p class="mt-1 text-lg font-semibold text-gray-900">{{ $patient->patient_name ?: 'Tidak dicatat' }}</p>
                    </div>
                    @if($patient->destination === 'IGD')
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        IGD
                    </span>
                    @else
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Ponek
                    </span>
                    @endif
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Keluhan / Diagnosis Awal</h3>
                    <p class="mt-1 text-gray-900">{{ $patient->patient_condition ?: 'Tidak dicatat' }}</p>
                </div>

                <div class="border-t border-gray-200 pt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase">Waktu Kedatangan</h3>
                        <p class="mt-1 text-gray-900 font-semibold">{{ $patient->arrival_time->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Info Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-bold text-gray-900">Informasi Transaksi</h3>
        </div>

        <div class="p-6 space-y-4">
            <div>
                <h3 class="text-sm font-medium text-gray-500 uppercase">ID Transaksi</h3>
                <p class="mt-1 text-lg font-mono font-semibold text-gray-900">{{ $patient->transaction->transaction_id }}</p>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-sm font-medium text-gray-500 uppercase mb-3">Driver yang Mengantar</h3>
                <div class="flex items-center bg-gray-50 rounded-lg p-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-xl mr-4">
                        {{ strtoupper(substr($patient->transaction->driver->name, 0, 2)) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-lg font-semibold text-gray-900">{{ $patient->transaction->driver->name }}</p>
                        <p class="text-sm text-gray-500">{{ $patient->transaction->driver->driver_id_card }}</p>
                        <p class="text-sm text-gray-500">{{ $patient->transaction->driver->phone_number }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            +{{ $patient->transaction->points_awarded }} poin
                        </span>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Waktu Scan</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $patient->transaction->scan_time->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Status Transaksi</h3>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Confirmed
                    </span>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase">Dikonfirmasi Oleh</h3>
                    <p class="mt-1 text-sm text-gray-900">{{ $patient->transaction->confirmedBy->name ?? 'Admin' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
