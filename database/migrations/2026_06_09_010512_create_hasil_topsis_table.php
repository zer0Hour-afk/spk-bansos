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
        Schema::create('hasil_topsis', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel warga sebagai penerima hasil perhitungan [cite: 126]
            $table->foreignId('warga_id')->constrained('wargas')->onDelete('cascade'); 
            $table->double('jarak_positif'); // Menyimpan akumulasi nilai Jarak Positif (D+) [cite: 155, 184]
            $table->double('jarak_negatif'); // Menyimpan akumulasi nilai Jarak Negatif (D-) [cite: 155, 184]
            $table->double('nilai_preferensi'); // Skor kedekatan relatif akhir (V) [cite: 156, 186]
            $table->integer('ranking'); // Hasil urutan prioritas peringkat warga [cite: 157, 190]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_topsis');
    }
};