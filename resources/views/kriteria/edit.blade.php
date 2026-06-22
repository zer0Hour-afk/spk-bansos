@extends('layouts.admin')

@section('title', 'Edit Kriteria')
@section('header', 'Edit Kriteria')

@section('content')
    <div class="bg-white rounded-lg shadow p-6 max-w-2xl mx-auto">
        <form action="{{ route('kriteria.update', $kriteria) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Kode Kriteria</label>
                <div class="mt-1 text-gray-900 font-medium">{{ $kriteria->kode }}</div>
            </div>

            <div class="mb-4">
                <label for="nama_kriteria" class="block text-sm font-medium text-gray-700">Nama Kriteria</label>
                <input id="nama_kriteria" name="nama_kriteria" type="text" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @error('nama_kriteria')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="sifat" class="block text-sm font-medium text-gray-700">Sifat</label>
                    <select id="sifat" name="sifat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="Benefit" {{ old('sifat', $kriteria->sifat) == 'Benefit' ? 'selected' : '' }}>Benefit</option>
                        <option value="Cost" {{ old('sifat', $kriteria->sifat) == 'Cost' ? 'selected' : '' }}>Cost</option>
                    </select>
                    @error('sifat')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bobot" class="block text-sm font-medium text-gray-700">Bobot (%)</label>
                    <input id="bobot" name="bobot" type="number" value="{{ old('bobot', $kriteria->bobot) }}" min="1" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('bobot')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('kriteria.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Perbarui</button>
            </div>
        </form>
    </div>
@endsection
