<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}