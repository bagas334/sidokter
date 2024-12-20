<?php

namespace App\DTOs;

class KegiatanDTO
{
    public $id;
    public $nama;
    public $asalFungsi;
    public $periode;
    public $tanggalMulai;
    public $tanggalAkhir;
    public $target;
    public $satuan;
    public $hargaSatuan;


    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->nama = $data['nama'] ?? null;
        $this->asalFungsi = $data['asal_fungsi'] ?? null;
        $this->periode = $data['periode'] ?? null;
        $this->tanggalMulai = $data['tanggal_mulai'] ?? null;
        $this->tanggalAkhir = $data['tanggal_akhir'] ?? null;
        $this->target = $data['target'] ?? null;
        $this->satuan = $data['satuan'] ?? null;
        $this->hargaSatuan = $data['harga_satuan'] ?? null;
    }
}
