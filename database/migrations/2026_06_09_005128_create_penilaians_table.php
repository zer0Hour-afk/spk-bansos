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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            // Menghubungkan penilaian dengan data alternatif warga [cite: 125]
            $table->foreignId('warga_id')->constrained('wargas')->onDelete('cascade'); 
            // Menghubungkan penilaian dengan parameter kriteria [cite: 125]
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade'); 
            $table->integer('nilai'); // Nilai skor awal berdasarkan skala penilaian 1-5 [cite: 125, 160]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};