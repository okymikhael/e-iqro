<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kegiatan;

class AktifitasSiswa extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function comments()
    {
        return $this->belongsTo(Kegiatan::class, 'foreign_key', 'owner_key');
    }
}
