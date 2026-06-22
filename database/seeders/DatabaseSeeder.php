<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Desa',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Kepala Desa',
            'email' => 'kepala@example.com',
            'role' => 'kepala_desa',
        ]);

        $kriterias = [
            ['kode' => 'C1', 'nama_kriteria' => 'Penghasilan Keluarga', 'sifat' => 'Cost', 'bobot' => 30],
            ['kode' => 'C2', 'nama_kriteria' => 'Jumlah Tanggungan', 'sifat' => 'Benefit', 'bobot' => 20],
            ['kode' => 'C3', 'nama_kriteria' => 'Kondisi Rumah', 'sifat' => 'Benefit', 'bobot' => 20],
            ['kode' => 'C4', 'nama_kriteria' => 'Status Pekerjaan', 'sifat' => 'Benefit', 'bobot' => 15],
            ['kode' => 'C5', 'nama_kriteria' => 'Kondisi Kesehatan', 'sifat' => 'Benefit', 'bobot' => 15],
        ];

        foreach ($kriterias as $kriteria) {
            Kriteria::firstOrCreate(
                ['kode' => $kriteria['kode']],
                $kriteria
            );
        }
    }
}
