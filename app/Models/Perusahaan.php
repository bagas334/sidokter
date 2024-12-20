<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaan';

    protected $fillable = [
        'idsbr',
        'kode_wilayah',
        'nama_usaha',
        'sls',
        'alamat_detail',
        'kode_kbli',
        'nama_cp',
        'nomor_cp',
        'email',
    ];

    protected $casts = [
        'idsbr' => 'string',
        'kode_wilayah' => 'string',
        'nama_usaha' => 'string',
        'sls' => 'string',
        'kode_kbli' => 'string',
        'nama_cp' => 'string',
        'nomor_cp' => 'string',
        'email' => 'string',
    ];

    public $timestamps = false;

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class, 'kode_wilayah', 'kode');
    }

    public static function getTopSampledPerusahaan($banyak = 10)
    {
        return self::select('perusahaan.nama_usaha', 'perusahaan.kode_kbli', DB::raw('COUNT(kegiatan.id) as jumlah_kegiatan'))
            ->join('sampel', 'perusahaan.id', '=', 'sampel.perusahaan_id')
            ->join('kegiatan', 'kegiatan.id', '=', 'sampel.kegiatan_id')
            ->groupBy('perusahaan.id', 'perusahaan.nama_usaha', 'perusahaan.kode_kbli')
            ->orderByDesc('jumlah_kegiatan')
            ->take($banyak)
            ->get()
            ->map(fn($item, $index) => $item->setAttribute('rank', $index + 1));
    }

    public static function getAllWithWilayah($paginate = 25)
    {
        $perusahaanColumns = Schema::getColumnListing('perusahaan');
        $excludeColumns = ['kode_wilayah'];
        $selectedColumns = array_diff($perusahaanColumns, $excludeColumns);
        $selectedColumns = array_map(function($column) {
            return 'perusahaan.' . $column;
        }, $selectedColumns);

        $selectedColumns = array_merge($selectedColumns, [
            'wilayah.kecamatan', 'wilayah.kelurahan'
        ]);

        return self::leftjoin('wilayah', 'perusahaan.kode_wilayah', '=', 'wilayah.kode')
            ->select($selectedColumns)
            ->paginate($paginate);
    }

}
