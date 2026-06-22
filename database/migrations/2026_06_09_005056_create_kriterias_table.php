<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // Untuk menyimpan C1, C2, C3, C4, C5 [cite: 162]
            $table->string('nama_kriteria'); // Nama indikator penilaian [cite: 37, 162]
            $table->float('bobot'); // Nilai persentase bobot kriteria [cite: 37, 162]
            $table->enum('sifat', ['Benefit', 'Cost']); // Sifat dari masing-masing kriteria [cite: 124, 162]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriterias');
    }
};
