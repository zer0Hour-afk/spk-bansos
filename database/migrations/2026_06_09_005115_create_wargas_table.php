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
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique(); // Nomor Induk Kependudukan warga [cite: 29]
            $table->string('nama'); // Nama lengkap alternatif warga [cite: 29, 163]
            $table->string('jenis_kelamin')->nullable();
            $table->string('status')->nullable(); // Menampilkan status kelayakan atau verifikasi [cite: 123]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};