<?php

namespace App\DTOs;

class MitraDTO
{
    public int $id;
    public string $sobat_id;
    public string $nama;
    public string $jenis_kelamin;
    public string $email;
    public string $posisi;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->sobat_id = $data['sobat_id'];
        $this->nama = $data['nama'];
        $this->jenis_kelamin = $data['jenis_kelamin'];
        $this->email = $data['email'];
        $this->posisi = $data['posisi'];
    }
}
