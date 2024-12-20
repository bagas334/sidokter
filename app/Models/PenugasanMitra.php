<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanMitra extends Model
{
    use HasFactory;

    protected $table = 'penugasan_mitra';

    protected $fillable = [
        'petugas',
        'kegiatan_id',
        'tanggal_penugasan',
        'pemberi_tugas',
        'jabatan',
        'target',
        'terlaksana',
        'catatan',
    ];

    // Relationships
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'petugas');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public static function getByKegiatan($id)
    {
        return self::where('kegiatan', $id)->get();
    }


    public function pemberiTugas()
    {
        return $this->belongsTo(Pegawai::class, 'pemberi_tugas');
    }

    public static function getAll($paginate = 10)
    {
        return self::join('mitra', 'penugasan_mitra.petugas', '=', 'mitra.id')
            ->join('kegiatan', 'penugasan_mitra.kegiatan', '=', 'kegiatan.id')
            ->join('pegawai AS pemberi_tugas_pegawai', 'penugasan_mitra.pemberi_tugas', '=', 'pemberi_tugas_pegawai.id')
            ->select(
                'penugasan_mitra.id',
                'mitra.nama AS nama_mitra',
                'kegiatan.nama AS nama_kegiatan',
                'pemberi_tugas_pegawai.nama AS nama_pemberi_tugas',
                'penugasan_mitra.tanggal_penugasan',
                'penugasan_mitra.volume',
                'kegiatan.harga_satuan',
                'penugasan_mitra.status'
            )
            ->paginate($paginate);
    }

    public static function getById($id)
    {
        return self::select(
            'penugasan_mitra.*',
            'kegiatan.nama as nama_kegiatan',
            'kegiatan.satuan as satuan_kegiatan',
            'kegiatan.harga_satuan as harga_satuan_kegiatan',
            'pemberi.nama as nama_pemberi_tugas',
            'pelaksana.nama as pelaksana'
        )
            ->join('kegiatan', 'penugasan_mitra.kegiatan', '=', 'kegiatan.id')
            ->join('pegawai as pemberi', 'penugasan_mitra.pemberi_tugas', '=', 'pemberi.id')
            ->join('mitra as pelaksana', 'penugasan_mitra.petugas', '=', 'pelaksana.id')
            ->where('penugasan_mitra.id', $id)
            ->first();
    }
}
