<?php

namespace App\DTOs;

class PegawaiDTO
{
    public $id;
    public $nip;
    public $nipBps;
    public $nama;
    public $alias;
    public $jabatan;
    public $golongan;
    public $status;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->nip = $data['nip'] ?? null;
        $this->nipBps = $data['nip_bps'] ?? null;
        $this->nama = $data['nama'] ?? null;
        $this->alias = $data['alias'] ?? null;
        $this->jabatan = $data['jabatan'] ?? null;
        $this->golongan = $data['golongan'] ?? null;
        $this->status = $data['status'] ?? null;
    }
}
