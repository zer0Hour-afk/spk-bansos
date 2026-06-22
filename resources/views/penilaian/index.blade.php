@extends('layouts.admin')

@section('title', 'Penilaian Alternatif')
@section('header', 'Penilaian Alternatif')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Penilaian Alternatif</h3>
            <p class="text-sm text-gray-500">Masukkan skor 1-5 untuk setiap warga berdasarkan setiap kriteria.</p>
        </div>
        <div class="text-sm text-gray-500">Skala: 1 (Terendah) sampai 5 (Tertinggi)</div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-4 text-green-700">{{ session('success') }}</div>
    @endif

    @if($wargas->isEmpty() || $kriterias->isEmpty())
        <div class="rounded-lg bg-yellow-50 border border-yellow-200 p-6 text-yellow-700">
            Data warga atau kriteria belum lengkap. Pastikan Anda sudah menambahkan warga dan kriteria sebelum mengisi penilaian.
        </div>
    @else
        @if($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-4 text-red-700">
                <p class="font-semibold">Perbaiki kesalahan berikut:</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('penilaian.store') }}" method="POST">
            @csrf
            <div class="overflow-x-auto bg-white rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warga</th>
                            @foreach($kriterias as $kriteria)
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $kriteria->kode }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($wargas as $warga)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $warga->nama }}<br><span class="text-xs text-gray-500">{{ $warga->nik }}</span></td>
                                @foreach($kriterias as $kriteria)
                                    @php
                                        $selected = old('nilai.'.$warga->id.'.'.$kriteria->id, optional($penilaians->get($warga->id.'_'.$kriteria->id))->nilai);
                                    @endphp
                                    <td class="px-4 py-4 text-center">
                                        <select name="nilai[{{ $warga->id }}][{{ $kriteria->id }}]" class="block w-full rounded-md border-gray-300 bg-white text-sm text-gray-700" required>
                                            <option value="">-</option>
                                            @for($value = 1; $value <= 5; $value++)
                                                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $value }}</option>
                                            @endfor
                                        </select>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan Penilaian</button>
            </div>
        </form>
    @endif
@endsection
