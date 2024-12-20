<?php

namespace App\Http\Controllers;

use App\Services\BasicRequestServiceInterface;
use Illuminate\Database\Eloquent\Model;

abstract class Controller
{
    private const SATUAN_KEGIATAN = [
        ['id' => 'oh', 'nama' => 'OH'],
        ['id' => 'ok', 'nama' => 'OK'],
    ];

    private const STATUS_KEGIATAN = [
        ['id' => 'ditugaskan', 'nama' => 'Ditugaskan'],
        ['id' => 'proses', 'nama' => 'Proses'],
        ['id' => 'selesai', 'nama' => 'Selesai'],
    ];

    private const FUNGSI = [
            ['ipds' => 'IPDS'],
            ['statistik produksi' => 'Statistik Produksi'],
            ['statistik_distribusi' => 'Statistik Distribusi'],
            ['statistik_sosial' => 'Statistik Sosial'],
            ['subbag_umum' => 'Subbag Umum'],
            ['nerwilis' => 'Nerwilis'],
    ];

    protected function getSatuanKegiatan(): array
    {
        return collect(self::SATUAN_KEGIATAN)->map(function($item) {
            return (object) $item;
        })->toArray();
    }

    protected function getStatusKegiatan(): array
    {
        return collect(self::STATUS_KEGIATAN)->map(function($item) {
            return (object) $item;
        })->toArray();
    }

    protected function getFungsi(): array
    {
        return collect(self::FUNGSI)->map(function($item) {
            return (object) $item;
        })->toArray();
    }
}
