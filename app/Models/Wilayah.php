<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'kode',
        'kecamatan',
        'kelurahan'
    ];

    public function perusahaan()
    {
        return $this->hasMany(Perusahaan::class, 'kode_wilayah', 'kode');
    }

    public static function getWilayahGrouped()
    {
        return self::select('kecamatan', 'kelurahan')
            ->get()
            ->groupBy('kecamatan')
            ->map(function ($group) {
                return $group->pluck('kelurahan')->toArray();
            })
            ->toArray();
    }

    public static function getKodeWilayahByKecamatanKelurahan($kecamatan, $kelurahan)
    {
        return self::where('kecamatan', $kecamatan)
            ->where('kelurahan', $kelurahan)
            ->first();
    }
}
