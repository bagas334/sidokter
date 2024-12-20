<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;
    protected $fillable = [
        'nip',
        'nip_bps',
        'nama',
        'alias',
        'jabatan',
        'fungsi_ketua_tim',
        'password'
    ];

    public function penugasanPegawai()
    {
        return $this->hasMany(PenugasanPegawai::class, 'petugas');
    }

    public static function getTugasPegawai()
    {
        $data = self::withCount('penugasanPegawai')->get();

        $sortedData = $data->sortByDesc('penugasan_pegawai_count');

        $names = $sortedData->pluck('nama');
        $tasks = $sortedData->pluck('penugasan_pegawai_count');

        return [
            'nama' => $names->toArray(),
            'tugas' => $tasks->toArray(),
        ];
    }

    public static function countPegawaiTerlibatKegiatan()
    {
        return self::has('penugasanPegawai')->count();
    }

    public static function getRerataBebanKerja()
    {
        $totalTugas = self::withCount('penugasanPegawai')->get()->sum('penugasan_pegawai_count');

        $totalPegawai = self::count();

        if ($totalPegawai == 0) {
            return 0;
        }

        return $totalTugas / $totalPegawai;
    }

    public static function getKetuaByFungsi($fungsi)
    {
        return self::select('pegawai.nama as nama_pegawai')
            ->where('pegawai.fungsi', $fungsi)
            ->where('pegawai.jabatan_tim', 'ketua')
            ->first();
    }

    public static function getAnggotaByFungsi($fungsi)
    {
        return self::select('pegawai.nama as nama_pegawai')
            ->where('pegawai.fungsi', $fungsi)
            ->where('pegawai.jabatan_tim', 'anggota')
            ->get();
    }

    public static function getJumlahKegiatanPerPegawaiByFungsi($fungsi)
    {
        return self::select('pegawai.nama as nama_pegawai', 'pegawai.jabatan_tim', DB::raw('COUNT(kegiatan.id) as jumlah_kegiatan'))
            ->leftJoin('penugasan_pegawai', 'penugasan_pegawai.petugas', '=', 'pegawai.id')
            ->leftJoin('kegiatan', 'kegiatan.id', '=', 'penugasan_pegawai.kegiatan')
            ->where('pegawai.fungsi', 'nerwilis')
            ->groupBy('pegawai.nama', 'pegawai.jabatan_tim')
            ->orderBy('pegawai.jabatan_tim')
            ->get();
    }
}
