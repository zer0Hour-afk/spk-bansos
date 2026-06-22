@extends('layouts.admin')

@section('title', 'Perhitungan TOPSIS')
@section('header', 'Perhitungan TOPSIS')

@section('content')
    <div class="space-y-6">
        @if(session('error'))
            <div class="rounded-lg bg-red-50 border border-red-200 p-4 text-red-700">{{ session('error') }}</div>
        @endif

        <div class="bg-white rounded-lg shadow p-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Ringkasan Data</h3>
                <p class="mt-2 text-sm text-gray-600">Berikut proses perhitungan TOPSIS berdasarkan data kriteria dan penilaian alternatif.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('topsis.export.pdf') }}" class="inline-flex items-center justify-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">Cetak PDF</a>
                <a href="{{ route('topsis.export.excel') }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-900 hover:bg-slate-50">Export Excel</a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="text-base font-semibold text-gray-900 mb-4">Matriks Awal</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warga</th>
                            @foreach($kriterias as $kriteria)
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $kriteria->kode }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($wargas as $warga)
                            <tr>
                                <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $warga->nama }}</td>
                                @foreach($kriterias as $kriteria)
                                    @php
                                        $nilai = optional($warga->penilaians->where('kriteria_id', $kriteria->id)->first())->nilai ?? 0;
                                    @endphp
                                    <td class="px-4 py-4 text-center text-sm text-gray-900">{{ $nilai }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="text-base font-semibold text-gray-900 mb-4">Matriks Normalisasi (R)</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warga</th>
                            @foreach($kriterias as $kriteria)
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $kriteria->kode }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($wargas as $warga)
                            <tr>
                                <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $warga->nama }}</td>
                                @foreach($kriterias as $kriteria)
                                    <td class="px-4 py-4 text-center text-sm text-gray-900">{{ number_format($matriksR[$warga->id][$kriteria->id], 4) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="text-base font-semibold text-gray-900 mb-4">Matriks Terbobot (Y)</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warga</th>
                            @foreach($kriterias as $kriteria)
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $kriteria->kode }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($wargas as $warga)
                            <tr>
                                <td class="px-4 py-4 text-sm font-medium text-gray-900">{{ $warga->nama }}</td>
                                @foreach($kriterias as $kriteria)
                                    <td class="px-4 py-4 text-center text-sm text-gray-900">{{ number_format($matriksY[$warga->id][$kriteria->id], 4) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="text-base font-semibold text-gray-900 mb-4">Solusi Ideal</h4>
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-lg border border-gray-200 p-4">
                    <h5 class="font-semibold text-gray-900">Ideal Positif (A+)</h5>
                    <dl class="mt-3 text-sm text-gray-700">
                        @foreach($kriterias as $kriteria)
                            <div class="flex justify-between py-1 border-b border-gray-100">
                                <dt>{{ $kriteria->kode }}</dt>
                                <dd>{{ number_format($idealPositif[$kriteria->id], 4) }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                <div class="rounded-lg border border-gray-200 p-4">
                    <h5 class="font-semibold text-gray-900">Ideal Negatif (A-)</h5>
                    <dl class="mt-3 text-sm text-gray-700">
                        @foreach($kriterias as $kriteria)
                            <div class="flex justify-between py-1 border-b border-gray-100">
                                <dt>{{ $kriteria->kode }}</dt>
                                <dd>{{ number_format($idealNegatif[$kriteria->id], 4) }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h4 class="text-base font-semibold text-gray-900 mb-4">Ranking Prioritas Penerima</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rangking</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Warga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">D+</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">D-</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Preferensi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($hasilAkhir as $index => $hasil)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $hasil['nama'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($hasil['jarak_positif'], 4) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($hasil['jarak_negatif'], 4) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ number_format($hasil['nilai_preferensi'], 4) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
