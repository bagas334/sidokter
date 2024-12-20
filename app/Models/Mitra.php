<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mitra extends Model
{
    use HasFactory;
    protected $table = 'mitra';

    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;
    protected $fillable = [
        'sobat_id',
        'nama',
        'jenis_kelamin',
        'email',
        'kecamatan',
        'kelurahan',
        'alamat_detail',
        'posisi',
        'pendapatan'
    ];

    protected $casts = [
        'jenis_kelamin' => 'string',
        'fungsi' => 'string',
    ];

    const PENDAPATAN_MAKS = 4200000;


    public function penugasanMitra()
    {
        return $this->hasMany(PenugasanMitra::class, 'petugas');
    }

    public static function getByKegiatan($id)
    {
        return self::where('kegiatan_id', $id);
    }

    public static function countMitraTerlibatKegiatan()
    {
        return self::has('penugasanMitra')->count();
    }

    public static function getTotalPendapatanFiltered()
    {
        $totalPendapatan = DB::raw('SUM(kegiatan.harga_satuan * penugasan_mitra.volume) as total_pendapatan');

        return self::select('mitra.nama as nama', 'mitra.id as id', $totalPendapatan)
            ->leftJoin('penugasan_mitra', 'mitra.id', '=', 'penugasan_mitra.petugas')
            ->join('kegiatan', 'penugasan_mitra.kegiatan', '=', 'kegiatan.id')
            ->groupBy('mitra.nama', 'mitra.id')
            ->havingRaw('total_pendapatan <= ? OR total_pendapatan IS NULL', [self::PENDAPATAN_MAKS])
            ->orderBy('mitra.nama', 'asc')
            ->get();
    }

    public static function getTotalPendapatan()
    {
        $totalPendapatan = DB::raw('SUM(kegiatan.harga_satuan * penugasan_mitra.volume) as total_pendapatan');

        return self::select('mitra.nama as nama_mitra', 'mitra.id as id_mitra', $totalPendapatan)
            ->leftJoin('penugasan_mitra', 'mitra.id', '=', 'penugasan_mitra.petugas')
            ->join('kegiatan', 'penugasan_mitra.kegiatan', '=', 'kegiatan.id')
            ->groupBy('mitra.nama', 'mitra.id')
            ->orderBy('total_pendapatan', 'desc')
            ->get();
    }
}
