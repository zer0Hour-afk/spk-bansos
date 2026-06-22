@extends('layouts.admin')

@section('title', 'Laporan TOPSIS Resmi')
@section('header', 'Laporan TOPSIS Resmi')

@section('content')
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <p class="text-sm uppercase text-slate-500">PEMERINTAH DESA SUKAMAJU</p>
                <h1 class="text-2xl font-semibold text-slate-900">Laporan Rekomendasi Prioritas Bansos</h1>
                <p class="mt-2 text-sm text-slate-500">Hasil perhitungan TOPSIS untuk menentukan prioritas penerima bantuan sosial</p>
                <p class="mt-1 text-sm text-slate-500">Tanggal: {{ now()->format('d F Y') }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-slate-900">Prioritas Utama</h2>
            @php
                $top = $hasilAkhir[0] ?? null;
            @endphp
            @if($top)
                <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-6">
                    <p class="text-sm text-slate-500">Warga Prioritas #1</p>
                    <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $top['nama'] }}</p>
                    <p class="mt-1 text-sm text-slate-600">Nilai Preferensi: {{ number_format($top['nilai_preferensi'], 4) }}</p>
                </div>
            @else
                <p class="text-sm text-slate-500">Belum ada data hasil TOPSIS.</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-slate-900">Daftar Ranking</h2>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Ranking</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">NIK</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500">Nilai Preferensi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($hasilAkhir as $index => $hasil)
                            @php
                                $warga = $wargas->firstWhere('id', $hasil['warga_id']);
                            @endphp
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-600">{{ $index + 1 }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900">{{ $warga?->nik ?? '-' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-slate-900">{{ $hasil['nama'] }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-slate-900">{{ number_format($hasil['nilai_preferensi'], 4) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 mt-6 bg-white rounded-lg shadow p-6">
            <div class="space-y-2">
                <p class="text-sm text-slate-500">Disusun oleh:</p>
                <div class="mt-4 h-16 border-b border-slate-200"></div>
                <p class="text-sm text-slate-700">Admin / Perangkat Desa</p>
            </div>
            <div class="space-y-2">
                <p class="text-sm text-slate-500">Diketahui oleh:</p>
                <div class="mt-4 h-16 border-b border-slate-200"></div>
                <p class="text-sm text-slate-700">Kepala Desa</p>
            </div>
        </div>
    </div>
@endsection