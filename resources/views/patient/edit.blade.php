@extends('layouts.app')

@section('title', 'Edit Data Pasien')
@section('page-title', 'Edit Data Pasien')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Edit Data Pasien</h2>
            <p class="text-gray-600 text-sm mt-1">Perbarui informasi pasien</p>
        </div>
        <a href="{{ route('patient.show', $patient) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('patient.update', $patient) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Informasi Pasien -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Pasien</h3>
                    
                    <div>
                        <label for="patient_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Pasien
                        </label>
                        <input type="text" 
                               id="patient_name" 
                               name="patient_name" 
                               value="{{ old('patient_name', $patient->patient_name) }}" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="Masukkan nama pasien">
                        @error('patient_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="patient_condition" class="block text-sm font-medium text-gray-700 mb-2">
                            Keluhan/Diagnosis
                        </label>
                        <textarea id="patient_condition" 
                                  name="patient_condition" 
                                  rows="4" 
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                  placeholder="Masukkan keluhan atau diagnosis pasien">{{ old('patient_condition', $patient->patient_condition) }}</textarea>
                        @error('patient_condition')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informasi Kunjungan -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Kunjungan</h3>
                    
                    <div>
                        <label for="destination" class="block text-sm font-medium text-gray-700 mb-2">
                            Tujuan <span class="text-red-500">*</span>
                        </label>
                        <select id="destination" 
                                name="destination" 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                required>
                            <option value="IGD" {{ old('destination', $patient->destination) === 'IGD' ? 'selected' : '' }}>IGD</option>
                            <option value="Ponek" {{ old('destination', $patient->destination) === 'Ponek' ? 'selected' : '' }}>Ponek</option>
                        </select>
                        @error('destination')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="arrival_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Waktu Kedatangan <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               id="arrival_time" 
                               name="arrival_time" 
                               value="{{ old('arrival_time', $patient->arrival_time->format('Y-m-d\TH:i')) }}" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               required>
                        @error('arrival_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Informasi Driver (Read-only) -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Informasi Driver</h4>
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-purple-600 rounded-lg flex items-center justify-center text-white font-semibold text-sm mr-3">
                                {{ strtoupper(substr($patient->transaction->driver->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $patient->transaction->driver->name }}</div>
                                <div class="text-xs text-gray-500">ID Transaksi: {{ $patient->transaction->transaction_id }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t">
                <a href="{{ route('patient.show', $patient) }}" 
                   class="px-6 py-2.5 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
