<?php

use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopsisController;
use App\Http\Controllers\WargaController;
use App\Http\Middleware\CheckRole;
use App\Models\Kriteria;
use App\Models\Warga;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $totalWarga = Warga::count();
        $totalKriteria = Kriteria::count();
        $wargaDinilai = Warga::whereHas('penilaians')->count();
        $kuotaBansos = config('bansos.kuota');

        return view('dashboard', compact('totalWarga', 'totalKriteria', 'wargaDinilai', 'kuotaBansos'));
    })->name('dashboard');

    Route::middleware([CheckRole::class . ':admin'])->group(function () {
        Route::resource('warga', WargaController::class)->except(['show']);
        Route::resource('kriteria', KriteriaController::class)->except(['show']);
        Route::resource('penilaian', PenilaianController::class)->only(['index', 'store']);
    });

    Route::get('/topsis', [TopsisController::class, 'index'])->name('topsis.index');
    Route::get('/topsis/report', [TopsisController::class, 'report'])->name('topsis.report');
    Route::get('/topsis/export/pdf', [TopsisController::class, 'exportPdf'])->name('topsis.export.pdf');
    Route::get('/topsis/export/excel', [TopsisController::class, 'exportExcel'])->name('topsis.export.excel');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
