<?php

namespace App\Entities;

class KegiatanEntity
{
    private $id;
    private $nama;
    private $asalFungsi;
    private $periode;
    private $tanggalMulai;
    private $tanggalAkhir;
    private $target;
    private $satuan;
    private $hargaSatuan;

    /**
     * @param $id
     * @param $nama
     * @param $asalFungsi
     * @param $periode
     * @param $tanggalMulai
     * @param $tanggalAkhir
     * @param $target
     * @param $satuan
     * @param $hargaSatuan
     */
    public function __construct($id, $nama, $asalFungsi, $periode, $tanggalMulai, $tanggalAkhir, $target, $satuan, $hargaSatuan)
    {
        $this->id = $id;
        $this->nama = $nama;
        $this->asalFungsi = $asalFungsi;
        $this->periode = $periode;
        $this->tanggalMulai = $tanggalMulai;
        $this->tanggalAkhir = $tanggalAkhir;
        $this->target = $target;
        $this->satuan = $satuan;
        $this->hargaSatuan = $hargaSatuan;
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
    public function getAsalFungsi()
    {
        return $this->asalFungsi;
    }

    /**
     * @param mixed $asalFungsi
     */
    public function setAsalFungsi($asalFungsi): void
    {
        $this->asalFungsi = $asalFungsi;
    }

    /**
     * @return mixed
     */
    public function getPeriode()
    {
        return $this->periode;
    }

    /**
     * @param mixed $periode
     */
    public function setPeriode($periode): void
    {
        $this->periode = $periode;
    }

    /**
     * @return mixed
     */
    public function getTanggalMulai()
    {
        return $this->tanggalMulai;
    }

    /**
     * @param mixed $tanggalMulai
     */
    public function setTanggalMulai($tanggalMulai): void
    {
        $this->tanggalMulai = $tanggalMulai;
    }

    /**
     * @return mixed
     */
    public function getTanggalAkhir()
    {
        return $this->tanggalAkhir;
    }

    /**
     * @param mixed $tanggalAkhir
     */
    public function setTanggalAkhir($tanggalAkhir): void
    {
        $this->tanggalAkhir = $tanggalAkhir;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     */
    public function setTarget($target): void
    {
        $this->target = $target;
    }

    /**
     * @return mixed
     */
    public function getSatuan()
    {
        return $this->satuan;
    }

    /**
     * @param mixed $satuan
     */
    public function setSatuan($satuan): void
    {
        $this->satuan = $satuan;
    }

    /**
     * @return mixed
     */
    public function getHargaSatuan()
    {
        return $this->hargaSatuan;
    }

    /**
     * @param mixed $hargaSatuan
     */
    public function setHargaSatuan($hargaSatuan): void
    {
        $this->hargaSatuan = $hargaSatuan;
    }

}
