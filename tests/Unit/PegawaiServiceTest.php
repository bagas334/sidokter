<?php

namespace Tests\Unit;

use App\Services\PegawaiService;
use Tests\TestCase;

class PegawaiServiceTest extends TestCase
{
    private $nip;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PegawaiService();
        $this->nip = '333333333333333333';
    }

    public function testCreatePegawaiShouldReturnCreated()
    {
        $nip = $this->nip;
        $data = [
            'nip' => $nip,
            'nip_bps' => '123456789',
            'nama' => 'NAMA-DUMMY',
            'alias' => 'DUMMY',
            'jabatan' => 'JABATAN-DUMMY',
            'golongan' => 'IV/A',
            'status' => 'PNS'
        ];

        $response = $this->service->create($data);

//        dump($response);

        $result = json_decode($response, true);

        $this->assertEquals('201', $result['status']);
    }

    public function testGetAllShouldReturnArray()
    {
        $result = $this->service->getAll();
//        dump($result);

        $this->assertIsArray($result);
    }

    public function testGetByIdShouldReturnObject()
    {
        $nip = $this->nip;
        $id = $this->service->getByNip($nip)->getId();
        $result = $this->service->getById($id);
//        dump($result);

        $this->assertIsObject($result);
    }

    public function testUpdatePegawaiShouldReturnUpdated()
    {
        $nip = $this->nip;
        $data = [
            'nip' => $nip,
            'nip_bps' => '123456789',
            'nama' => 'NAMA-DUMMY',
            'alias' => 'DUMMY',
            'jabatan' => 'JABATAN-DUMMY',
            'golongan' => 'IV/C',
            'status' => 'PNS'
        ];

        $id = $this->service->getByNip($nip)->getId();

        $response = $this->service->update($id, $data);

//        dump($response);

        $result = json_decode($response, true);

        $this->assertEquals('200', $result['status']);
    }

    public function testDeletePegawaiShouldReturnDeleted()
    {
        $nip = $this->nip;
        $id = $this->service->getByNip($nip)->getId();
        $response = $this->service->delete($id);

//        dump($response);

        $result = json_decode($response, true);

        $this->assertEquals('200', $result['status']);
    }
}
