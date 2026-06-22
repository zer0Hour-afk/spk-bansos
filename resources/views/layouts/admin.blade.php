<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SPK Bansos - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-slate-900 dark:text-slate-200 transition-colors duration-200 flex h-screen overflow-hidden">

    @php
        $role = Auth::user()?->role ?? 'admin';
    @endphp

    <aside class="w-64 bg-slate-800 text-white flex flex-col">
        <div class="h-16 flex items-center px-6 font-bold text-xl tracking-wider border-b border-slate-700">
            SPK BANSOS
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-slate-700">Dashboard</a>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('warga.index') }}" class="block px-4 py-2 rounded hover:bg-slate-700">Data Warga</a>
                <a href="{{ route('kriteria.index') }}" class="block px-4 py-2 rounded hover:bg-slate-700">Kriteria & Bobot</a>
                <a href="{{ route('penilaian.index') }}" class="block px-4 py-2 rounded hover:bg-slate-700">Penilaian Alternatif</a>
            @endif
            <a href="{{ route('topsis.index') }}" class="block px-4 py-2 rounded hover:bg-slate-700">Perhitungan TOPSIS</a>
            <a href="{{ route('topsis.report') }}" class="block px-4 py-2 rounded hover:bg-slate-700">Laporan Resmi</a>
        </nav>
        <div class="p-4 border-t border-slate-700">
            <div class="text-sm">{{ Auth::user()->isAdmin() ? 'Admin Desa' : 'Kepala Desa' }}</div>
            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                @csrf
                <button type="submit" class="text-xs text-red-400 hover:text-red-300">Logout</button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="h-16 bg-white dark:bg-slate-800 shadow flex items-center justify-between px-6">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-slate-100 leading-tight">
                @yield('header')
            </h2>
            <div class="flex items-center gap-4">
                <div class="text-sm text-gray-500 dark:text-slate-200">{{ Auth::user()->name ?? 'Administrator' }}</div>
                <button type="button" aria-label="Toggle theme" onclick="toggleTheme()" data-theme-toggle class="p-2 rounded-md bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 hover:bg-gray-200 dark:hover:bg-slate-600 transition" data-theme="">
                    <!-- icon set by JS -->
                </button>
                <button type="button" aria-label="Increase text" onclick="toggleLargeText()" class="p-2 rounded-md bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 hover:bg-gray-200 dark:hover:bg-slate-600 transition">
                    A+
                </button>
                <button type="button" aria-label="High contrast" onclick="toggleHighContrast()" class="p-2 rounded-md bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 hover:bg-gray-200 dark:hover:bg-slate-600 transition">
                    ⚑
                </button>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-slate-900 p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>