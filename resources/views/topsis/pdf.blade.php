<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan TOPSIS</title>
    <style>
        body { font-family: sans-serif; color: #111; margin: 0; padding: 24px; }
        .header { text-align: center; margin-bottom: 24px; }
        .header h1 { font-size: 24px; margin: 0; }
        .header p { margin: 6px 0 0; font-size: 12px; color: #555; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 24px; }
        th, td { border: 1px solid #999; padding: 8px 10px; font-size: 12px; }
        th { background: #f1f1f1; text-align: left; }
        .section-title { margin: 24px 0 12px; font-size: 16px; font-weight: bold; }
        .summary dt { float: left; clear: left; width: 180px; font-weight: bold; }
        .summary dd { margin: 0 0 6px 190px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Hasil Perhitungan TOPSIS</h1>
        <p>SPK Bansos - Data perhitungan prioritas penerima bantuan</p>
        <p>Tanggal: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <div>
        <h2 class="section-title">Ringkasan Kriteria</h2>
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Kriteria</th>
                    <th>Sifat</th>
                    <th>Bobot (%)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriterias as $kriteria)
                    <tr>
                        <td>{{ $kriteria->kode }}</td>
                        <td>{{ $kriteria->nama_kriteria }}</td>
                        <td>{{ $kriteria->sifat }}</td>
                        <td>{{ $kriteria->bobot }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        <h2 class="section-title">Rangking Warga</h2>
        <table>
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Nama Warga</th>
                    <th>D+</th>
                    <th>D-</th>
                    <th>Nilai Preferensi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasilAkhir as $index => $hasil)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $hasil['nama'] }}</td>
                        <td>{{ number_format($hasil['jarak_positif'], 6) }}</td>
                        <td>{{ number_format($hasil['jarak_negatif'], 6) }}</td>
                        <td>{{ number_format($hasil['nilai_preferensi'], 6) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        <h2 class="section-title">Solusi Ideal</h2>
        <table>
            <thead>
                <tr>
                    <th>Kode Kriteria</th>
                    <th>Ideal Positif (A+)</th>
                    <th>Ideal Negatif (A-)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($kriterias as $kriteria)
                    <tr>
                        <td>{{ $kriteria->kode }}</td>
                        <td>{{ number_format($idealPositif[$kriteria->id], 6) }}</td>
                        <td>{{ number_format($idealNegatif[$kriteria->id], 6) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
