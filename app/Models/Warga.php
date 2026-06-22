<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }

    public function hasilTopsis()
    {
        return $this->hasOne(HasilTopsis::class);
    }
}