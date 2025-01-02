<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sampel extends Model
{
    use HasFactory;

    protected $table = 'sampel';

    // Isi dengan kolom-kolom yang dapat diisi secara massal
    protected $fillable = [
        'nama',          // Nama sampel
        'deskripsi',     // Deskripsi sampel
        'dibuat_oleh',   // Foreign key ke tabel pegawai/users
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'dibuat_oleh', 'id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class); // pastikan Kegiatan adalah nama model yang benar
    }

    public function perusahaan()
    {
        return $this->belongsToMany(Perusahaan::class, 'perusahaan_sampel', 'sampel_id', 'perusahaan_id');
    }
}
