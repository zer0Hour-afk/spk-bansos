@extends('layouts.admin')

@section('title', 'Tambah Warga')
@section('header', 'Tambah Warga')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
        <form action="{{ route('warga.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                <input id="nik" name="nik" type="text" value="{{ old('nik') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @error('nik')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Warga</label>
                <input id="nama" name="nama" type="text" value="{{ old('nama') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @error('nama')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('warga.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection
