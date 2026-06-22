<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kriterias = Kriteria::orderBy('kode')->get();
        return view('kriteria.index', compact('kriterias'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'sifat' => 'required|in:Benefit,Cost',
            'bobot' => 'required|numeric|min:1|max:100',
        ]);

        $lastKode = Kriteria::select('kode')->orderByDesc('id')->first();
        $nextIndex = 1;
        if ($lastKode) {
            preg_match('/C(\d+)/', $lastKode->kode, $matches);
            $nextIndex = isset($matches[1]) ? intval($matches[1]) + 1 : Kriteria::count() + 1;
        }
        $validated['kode'] = 'C'.$nextIndex;

        Kriteria::create($validated);

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Kriteria $kriteria)
    {
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'sifat' => 'required|in:Benefit,Cost',
            'bobot' => 'required|numeric|min:1|max:100',
        ]);

        $kriteria->update($validated);

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
