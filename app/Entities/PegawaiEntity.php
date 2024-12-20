<?php

namespace App\Entities;

class PegawaiEntity
{
    private $id;
    private $nip;
    private $nipBps;
    private $nama;
    private $alias;
    private $jabatan;
    private $golongan;
    private $status;

    public function __construct(
        $id,
        $nip,
        $nipBps,
        $nama,
        $alias,
        $jabatan,
        $golongan,
        $status
    ) {
        $this->id = $id;
        $this->nip = $nip;
        $this->nipBps = $nipBps;
        $this->nama = $nama;
        $this->alias = $alias;
        $this->jabatan = $jabatan;
        $this->golongan = $golongan;
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * @param mixed $nip
     */
    public function setNip($nip): void
    {
        $this->nip = $nip;
    }

    /**
     * @return mixed
     */
    public function getNipBps()
    {
        return $this->nipBps;
    }

    /**
     * @param mixed $nipBps
     */
    public function setNipBps($nipBps): void
    {
        $this->nipBps = $nipBps;
    }

    /**
     * @return mixed
     */
    public function getNama()
    {
        return $this->nama;
    }

    /**
     * @param mixed $nama
     */
    public function setNama($nama): void
    {
        $this->nama = $nama;
    }

    /**
     * @return mixed
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param mixed $alias
     */
    public function setAlias($alias): void
    {
        $this->alias = $alias;
    }

    /**
     * @return mixed
     */
    public function getJabatan()
    {
        return $this->jabatan;
    }

    /**
     * @param mixed $jabatan
     */
    public function setJabatan($jabatan): void
    {
        $this->jabatan = $jabatan;
    }

    /**
     * @return mixed
     */
    public function getGolongan()
    {
        return $this->golongan;
    }

    /**
     * @param mixed $golongan
     */
    public function setGolongan($golongan): void
    {
        $this->golongan = $golongan;
    }

}
