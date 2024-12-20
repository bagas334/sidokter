<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;

    protected $table = 'tim';

    public $timestamps = false;

    protected $fillable = [
        'fungsi',
        'anggota',
        'status',
    ];

    /**
     * Define a relationship with the Pegawai model.
     */
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'anggota');
    }
}
