@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-sm font-medium text-slate-500">Total Warga Terdaftar</h3>
            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $totalWarga }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah semua warga yang tersimpan di sistem.</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-sm font-medium text-slate-500">Kriteria Aktif</h3>
            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $totalKriteria }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah kriteria yang sedang digunakan dalam TOPSIS.</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-sm font-medium text-slate-500">Kuota Bansos</h3>
            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $kuotaBansos }}</p>
            <p class="mt-2 text-sm text-slate-500">Batas kuota penerima bantuan berdasarkan kebijakan desa.</p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-sm font-medium text-slate-500">Warga Sudah Dinilai</h3>
            <p class="mt-4 text-3xl font-semibold text-slate-900">{{ $wargaDinilai }}</p>
            <p class="mt-2 text-sm text-slate-500">Jumlah warga yang sudah terisi nilai penilaian.</p>
        </div>
    </div>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h3 class="text-lg font-semibold text-slate-900">Halo, {{ Auth::user()->name }}!</h3>
        @if(Auth::user()->isAdmin())
            <p class="mt-2 text-sm text-slate-600">Anda memiliki akses penuh untuk mengelola data warga, kriteria, dan penilaian. Gunakan menu di sebelah untuk melakukan input data dan mencetak laporan resmi.</p>
        @else
            <p class="mt-2 text-sm text-slate-600">Anda memiliki hak akses read-only untuk melihat rekomendasi prioritas bansos. Silakan gunakan menu laporan untuk melihat hasil final dan mencetak file PDF.</p>
        @endif
    </div>
@endsection
