<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sampel extends Model
{
    use HasFactory;

    protected $table = 'sampel';

    protected $fillable = [
        'kegiatan_id',
        'perusahaan_id',
        'dibuat_oleh'
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'perusahaan_id');
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(Pegawai::class, 'dibuat_oleh');
    }

    public static function getDaftarSampel($kegiatanId)
    {
        return self::where('kegiatan_id', $kegiatanId)
            ->join('perusahaan', 'sampel.perusahaan_id', '=', 'perusahaan.id')
            ->select(
                'sampel.id as id',
                'perusahaan.id as perusahaan_id',
                'perusahaan.nama_usaha as nama_perusahaan',
                'perusahaan.email as email',
                'perusahaan.nama_cp as nama_cp',
                'perusahaan.nomor_cp as nomor_cp'
            )
            ->get();
    }
}
