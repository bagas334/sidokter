<?php

namespace App\Entities;

use App\DTOs\MitraDTO;

class MitraEntity
{
    private int $id;
    private string $sobat_id;
    private string $nama;
    private string $jenis_kelamin;
    private string $email;
    private string $posisi;

    public function __construct(
        int $id,
        string $sobat_id,
        string $nama,
        string $jenis_kelamin,
        string $email,
        string $posisi
    ) {
        $this->id = $id;
        $this->sobat_id = $sobat_id;
        $this->nama = $nama;
        $this->jenis_kelamin = $jenis_kelamin;
        $this->email = $email;
        $this->posisi = $posisi;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSobatId(): string
    {
        return $this->sobat_id;
    }

    public function setSobatId(string $sobat_id): void
    {
        $this->sobat_id = $sobat_id;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function setNama(string $nama): void
    {
        $this->nama = $nama;
    }

    public function getJenisKelamin(): string
    {
        return $this->jenis_kelamin;
    }

    public function setJenisKelamin(string $jenis_kelamin): void
    {
        $this->jenis_kelamin = $jenis_kelamin;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPosisi(): string
    {
        return $this->posisi;
    }

    public function setPosisi(string $posisi): void
    {
        $this->posisi = $posisi;
    }


}
