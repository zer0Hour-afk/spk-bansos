<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\Warga;
use Barryvdh\DomPDF\Facade\Pdf;

class TopsisController extends Controller
{
    public function index()
    {
        $data = $this->prepareTopsisData();
        if ($data === null) {
            return redirect()->route('dashboard')->with('error', 'Data Kriteria atau Penilaian Warga masih kosong.');
        }

        return view('topsis.index', $data);
    }

    public function exportPdf()
    {
        $data = $this->prepareTopsisData();
        if ($data === null) {
            return redirect()->route('dashboard')->with('error', 'Data Kriteria atau Penilaian Warga masih kosong.');
        }

        $filename = 'laporan_topsis_' . now()->format('Ymd_His') . '.pdf';
        $pdf = Pdf::loadView('topsis.pdf', $data)->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }

    public function exportExcel()
    {
        $data = $this->prepareTopsisData();
        if ($data === null) {
            return redirect()->route('dashboard')->with('error', 'Data Kriteria atau Penilaian Warga masih kosong.');
        }

        $filename = 'laporan_topsis_' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($data) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Ranking', 'Nama Warga', 'D+', 'D-', 'Nilai Preferensi']);

            foreach ($data['hasilAkhir'] as $index => $hasil) {
                fputcsv($handle, [
                    $index + 1,
                    $hasil['nama'],
                    number_format($hasil['jarak_positif'], 6),
                    number_format($hasil['jarak_negatif'], 6),
                    number_format($hasil['nilai_preferensi'], 6),
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function report()
    {
        $data = $this->prepareTopsisData();
        if ($data === null) {
            return redirect()->route('dashboard')->with('error', 'Data Kriteria atau Penilaian Warga masih kosong.');
        }

        return view('topsis.report', $data);
    }

    private function prepareTopsisData()
    {
        $kriterias = Kriteria::orderBy('kode')->get();
        $wargas = Warga::with('penilaians')->get();

        if ($kriterias->isEmpty() || $wargas->isEmpty()) {
            return null;
        }

        $pembagi = [];
        foreach ($kriterias as $kriteria) {
            $totalKuadrat = 0;
            foreach ($wargas as $warga) {
                $nilai = $warga->penilaians->where('kriteria_id', $kriteria->id)->first()->nilai ?? 0;
                $totalKuadrat += pow($nilai, 2);
            }
            $pembagi[$kriteria->id] = sqrt($totalKuadrat);
        }

        $matriksR = [];
        $matriksY = [];
        foreach ($wargas as $warga) {
            foreach ($kriterias as $kriteria) {
                $nilai = $warga->penilaians->where('kriteria_id', $kriteria->id)->first()->nilai ?? 0;
                $nilaiR = $pembagi[$kriteria->id] == 0 ? 0 : $nilai / $pembagi[$kriteria->id];
                $matriksR[$warga->id][$kriteria->id] = $nilaiR;
                $matriksY[$warga->id][$kriteria->id] = $nilaiR * $kriteria->bobot;
            }
        }

        $idealPositif = [];
        $idealNegatif = [];
        foreach ($kriterias as $kriteria) {
            $kolomY = array_column($matriksY, $kriteria->id);
            if ($kriteria->sifat == 'Benefit') {
                $idealPositif[$kriteria->id] = max($kolomY);
                $idealNegatif[$kriteria->id] = min($kolomY);
            } else {
                $idealPositif[$kriteria->id] = min($kolomY);
                $idealNegatif[$kriteria->id] = max($kolomY);
            }
        }

        $hasilAkhir = [];
        foreach ($wargas as $warga) {
            $totalDPositif = 0;
            $totalDNegatif = 0;
            foreach ($kriterias as $kriteria) {
                $nilaiY = $matriksY[$warga->id][$kriteria->id];
                $totalDPositif += pow($nilaiY - $idealPositif[$kriteria->id], 2);
                $totalDNegatif += pow($nilaiY - $idealNegatif[$kriteria->id], 2);
            }
            $jarakPositif = sqrt($totalDPositif);
            $jarakNegatif = sqrt($totalDNegatif);
            $nilaiV = ($jarakNegatif + $jarakPositif) == 0 ? 0 : $jarakNegatif / ($jarakNegatif + $jarakPositif);
            $hasilAkhir[] = [
                'warga_id' => $warga->id,
                'nama' => $warga->nama,
                'jarak_positif' => $jarakPositif,
                'jarak_negatif' => $jarakNegatif,
                'nilai_preferensi' => $nilaiV,
            ];
        }

        usort($hasilAkhir, function ($a, $b) {
            return $b['nilai_preferensi'] <=> $a['nilai_preferensi'];
        });

        return compact('kriterias', 'wargas', 'pembagi', 'matriksR', 'matriksY', 'idealPositif', 'idealNegatif', 'hasilAkhir');
    }
}
