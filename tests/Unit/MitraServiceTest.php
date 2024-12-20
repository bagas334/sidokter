<?php

namespace Tests\Unit;

use App\Services\MitraServices;
use Tests\TestCase;

class MitraServiceTest extends TestCase
{
    private $sobat_id;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new MitraServices();
        $this->sobat_id = '317223110044';
        $this->sobat_id = '111111111111';
    }

    public function testGetAllShouldReturnArray()
    {
        $result = $this->service->getAll();
//        dump($result);

        $this->assertIsArray($result);
    }

    public function testCreateMitraShouldReturnCreated()
    {
        $sobat_id = $this->sobat_id;
        $data = [
            'sobat_id' => $sobat_id,
            'nama' => 'NAMA-DUMMY',
            'jenis_kelamin' => 'laki-laki',
            'email' => 'EMAILDUMMY@gmail.com',
            'posisi' => 'pengolahan'
        ];

        $response = $this->service->create($data);

//        dump($response);

        $result = json_decode($response, true);

        $this->assertEquals('201', $result['status']);
    }

    public function testGetByIdShouldReturnObject()
    {
        $sobat_id = $this->sobat_id;
        $id = $this->service->getBySobatId($sobat_id)->getId();
        $result = $this->service->getById($id);
//        dump($result);

        $this->assertIsObject($result);
    }

    public function testUpdateMitraShouldReturnUpdated()
    {
        $sobat_id = $this->sobat_id;
        $data = [
            'sobat_id' => $sobat_id,
            'nama' => 'NAMA-DUMMY',
            'jenis_kelamin' => 'perempuan',
            'email' => 'Testgmail@gmail.com',
            'posisi' => 'pendataan'
        ];

        $id = $this->service->getBySobatId($sobat_id)->getId();

        $response = $this->service->update($id, $data);

//        dump($response);

        $result = json_decode($response, true);

        $this->assertEquals('200', $result['status']);
    }

    public function testDeleteMitraShouldReturnDeleted()
    {
        $sobat_id = $this->sobat_id;
        $id = $this->service->getBySobatId($sobat_id)->getId();
        $response = $this->service->delete($id);
        $result = json_decode($response, true);

        $this->assertEquals('200', $result['status']);
    }

}
