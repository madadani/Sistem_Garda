@extends('layouts.app')

@section('title', 'Tambah Driver')
@section('page-title', 'Tambah Driver')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary-600 to-purple-600 px-6 py-4">
            <h3 class="text-xl font-semibold text-white">Form Tambah Driver Baru</h3>
        </div>

        <!-- Form -->
        <form action="{{ route('driver.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Driver <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror"
                    placeholder="Masukkan nama driver"
                    required
                >
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">
                    Nomor Telepon <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="phone_number" 
                    name="phone_number" 
                    value="{{ old('phone_number') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('phone_number') border-red-500 @enderror"
                    placeholder="Contoh: 081234567890"
                    required
                >
                @error('phone_number')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Nomor telepon akan digunakan sebagai ID Card driver</p>
            </div>

               <!-- Instansi -->
            <div>
                <label for="instansi" class="block text-sm font-medium text-gray-700 mb-2">
                    Instansi
                </label>
                <input 
                    type="text" 
                    id="instansi" 
                    name="instansi" 
                    value="{{ old('instansi') }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('instansi') border-red-500 @enderror"
                    placeholder="Masukkan nama instansi (opsional)"
                >
                @error('instansi')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Nama instansi tempat driver bekerja</p>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                <a href="{{ route('driver.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-primary-600 to-purple-600 text-white font-medium rounded-lg hover:from-primary-700 hover:to-purple-700 transition-all hover:scale-105">
                    Simpan Driver
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
