@extends('layouts.public')

@section('title', 'Scan Berhasil')

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-green-500 via-teal-600 to-blue-500 flex items-center justify-center p-4 relative">

        <!-- Modal Form Data Pasien -->
        <div id="patientModal"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-20 hidden">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-1">Input Data Pasien</h2>
                <p class="text-sm text-gray-500 mb-4">Silakan lengkapi data pasien yang sedang diantar.</p>

                <!-- Informasi Driver -->
                <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4">
                    <div class="flex items-center mb-3">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 text-sm">Informasi Driver</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                        <div>
                            <span class="text-gray-500 font-medium">Nama:</span>
                            <span class="text-gray-800 font-medium ml-2">{{ $driver->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 font-medium">ID Card:</span>
                            <span
                                class="text-gray-800 font-mono bg-white px-2 py-1 rounded ml-2">{{ $driver->driver_id_card }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 font-medium">No. HP:</span>
                            <span
                                class="text-gray-800 font-medium ml-2">{{ $driver->phone_number ?? 'Tidak Ada' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 font-medium">Instansi:</span>
                            <span class="text-gray-800 font-medium ml-2">{{ $driver->instansi ?? 'Tidak Ada' }}</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('driver.scan.patient.validate', $driver->driver_id_card) }}" method="POST"
                    class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pasien</label>
                        <input type="text" name="patient_name"
                            value="{{ old('patient_name') ?? session('patient_input_data.patient_name') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Masukkan nama pasien">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan</label>
                        <textarea name="patient_condition" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Tuliskan keluhan utama pasien">{{ old('patient_condition') ?? session('patient_input_data.patient_condition') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tujuan <span class="text-red-500"></span>
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-4 border-2 border-gray-200 rounded-xl">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="destination" value="IGD" {{ old('destination') === 'IGD' || (session('patient_input_data.destination') === 'IGD') || (!old('destination') && !session('patient_input_data.destination')) ? 'checked' : '' }} required
                                        class="mr-3 text-primary-600 focus:ring-primary-500">
                                    <div class="flex-1 flex items-center">
                                        <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                        </svg>
                                        <div class="font-semibold text-gray-900">IGD</div>
                                    </div>
                                </label>
                            </div>
                            <div class="p-4 border-2 border-gray-200 rounded-xl">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="destination" value="Ponek" {{ old('destination') === 'Ponek' || (session('patient_input_data.destination') === 'Ponek') ? 'checked' : '' }}
                                        required class="mr-3 text-primary-600 focus:ring-primary-500">
                                    <div class="flex-1 flex items-center">
                                        <svg class="w-6 h-6 mr-3" style="color: #ec4899;" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                        </svg>
                                        <div class="font-semibold text-gray-900">PONEK</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @error('destination')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" onclick="window.location.href='{{ route('scan.landing') }}'"
                            class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 text-sm font-medium">Batal</button>
                        <button type="submit"
                            class="px-5 py-2 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-green-700">Next</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <script>
            function openPatientModal() {
                var modal = document.getElementById('patientModal');
                if (modal) {
                    modal.classList.remove('hidden');
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                // Otomatis buka form data pasien setelah halaman scan sukses muncul
                openPatientModal();

                // Bersihkan session patient_input_data setelah modal dibuka
                setTimeout(() => {
                    fetch('{{ route("driver.scan", $driver->driver_id_card) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ action: 'clear_session_data' })
                    }).catch(() => {
                        // Ignore error if request fails
                    });
                }, 1000);
            });
        </script>
@endsection