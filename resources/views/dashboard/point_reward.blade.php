@extends('layouts.app')

@section('title', 'Point & Reward')
@section('page-title', 'Point & Reward')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Daftar Point Driver</h2>
        <a href="{{ route('dashboard.point.export') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Export Excel</a>
    </div>
    <div class="bg-white rounded-xl shadow-md p-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID Card</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Driver</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Instansi</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total Point</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $driver)
                <tr>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $driver->driver_id_card }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $driver->name }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">{{ $driver->instansi }}</td>
                    <td class="px-4 py-2 text-sm text-green-700 font-bold">{{ $driver->total_points }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
