<?php

namespace Tests\Unit;

use App\Services\KegiatanService;
use Tests\TestCase;

class KegiatanServiceTest extends TestCase
{
    private $nama;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new KegiatanService();
        $this->nama = 'NAMA-DUMMY';
    }

    public function testGetAllShouldReturnArray()
    {
        $result = $this->service->getAll();
//        dump($result);

        $this->assertIsArray($result);
    }

    public function testCreateKegiatanShouldReturnCreated()
    {
        $nama = $this->nama;
        $data = [
            'nama' => $nama,
            'asal_fungsi' => 'ASAL-FUNGSI-DUMMY',
            'periode' => 'PERIODE-DUMMY',
            'tanggalMulai' => '2021-01-01',
            'tanggalAkhir' => '2021-12-31',
            'target' => 100,
            'satuan' => 'SATUAN-DUMMY',
            'hargaSatuan' => 100000
        ];

        $response = $this->service->create($data);

//        dump($response);

        $result = json_decode($response, true);

        $this->assertEquals('201', $result['status']);
    }

    public function testGetByIdShouldReturnObject()
    {
        $nama = $this->nama;
        $id = $this->service->getByNama($nama)->getId();
        $result = $this->service->getById($id);
//        dump($result);

        $this->assertIsObject($result);
    }

    public function testUpdateKegiatanShouldReturnUpdated()
    {
        $nama = $this->nama;
        $data = [
            'nama' => $nama,
            'asal_fungsi' => 'ASAL-FUNGSI-DUMMY',
            'periode' => 'PERIODE-DUMMY',
            'tanggalMulai' => '2021-01-01',
            'tanggalAkhir' => '2021-12-31',
            'target' => 100,
            'satuan' => 'SATUAN-DUMMIES',
            'hargaSatuan' => 100000
        ];

        $id = $this->service->getByNama($nama)->getId();

        $response = $this->service->update($id, $data);

//        dump($response);

        $result = json_decode($response, true);

        $this->assertEquals('200', $result['status']);
    }

    public function testDeletePegawaiShouldReturnDeleted()
    {
        $nama = $this->nama;
        $id = $this->service->getByNama($nama)->getId();
        $response = $this->service->delete($id);

//        dump($response);

        $result = json_decode($response, true);

        $this->assertEquals('200', $result['status']);
    }
}
