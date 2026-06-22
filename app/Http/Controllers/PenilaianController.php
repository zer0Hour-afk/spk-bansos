<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Warga;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wargas = Warga::orderBy('nama')->get();
        $kriterias = Kriteria::orderBy('kode')->get();
        $penilaians = Penilaian::get()->keyBy(fn($item) => $item->warga_id.'_'.$item->kriteria_id);

        return view('penilaian.index', compact('wargas', 'kriterias', 'penilaians'));
    }

    public function store(Request $request)
    {
        $wargas = Warga::orderBy('nama')->get();
        $kriterias = Kriteria::orderBy('kode')->get();

        $rules = [
            'nilai' => 'required|array',
        ];

        foreach ($wargas as $warga) {
            foreach ($kriterias as $kriteria) {
                $rules["nilai.{$warga->id}.{$kriteria->id}"] = 'required|integer|min:1|max:5';
            }
        }

        $messages = [
            'nilai.required' => 'Form penilaian harus diisi.',
            'nilai.*.*.required' => 'Semua nilai penilaian harus diisi.',
            'nilai.*.*.integer' => 'Nilai penilaian harus berupa angka.',
            'nilai.*.*.min' => 'Nilai penilaian minimal adalah 1.',
            'nilai.*.*.max' => 'Nilai penilaian maksimal adalah 5.',
        ];

        $validated = $request->validate($rules, $messages);

        foreach ($validated['nilai'] as $wargaId => $kriteriaValues) {
            foreach ($kriteriaValues as $kriteriaId => $nilai) {
                Penilaian::updateOrCreate(
                    ['warga_id' => $wargaId, 'kriteria_id' => $kriteriaId],
                    ['nilai' => $nilai]
                );
            }
        }

        return redirect()->route('penilaian.index')->with('success', 'Penilaian alternatif berhasil disimpan.');
    }
}
