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

    public function sampel()
    {
        return $this->belongsToMany(Sampel::class, 'perusahaan_sampel', 'perusahaan_id', 'sampel_id');
    }
}
