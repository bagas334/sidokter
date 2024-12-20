<?php

namespace App\Services;

use App\DTOs\MitraDTO;
use App\Entities\MitraEntity;
use Illuminate\Support\Facades\Http;

class MitraServices extends AbstractRequestService
{
    public function __construct()
    {
        parent::__construct(config('services.api.base_url') . '/mitra');
    }

    /**
     * @throws \Exception
     */
    public function getAll(): array
    {
        $response = Http::get($this->apiUrl);

        if (!$response->successful()) {
            throw new \Exception($response->json('errors'));
        }

        $data = $response->json(['data']);
        $mitraEntities = [];

        foreach ($data as $item) {
            $mitraDTO = new MitraDTO($item);

            $mitraEntity = new MitraEntity(
                $mitraDTO->id,
                $mitraDTO->sobat_id,
                $mitraDTO->nama,
                $mitraDTO->jenis_kelamin,
                $mitraDTO->email,
                $mitraDTO->posisi
            );

            $mitraEntities[] = $mitraEntity;
        }
        return $mitraEntities;
    }

    /**
     * @throws \Exception
     */
    public function getById($id): object
    {
        $response = Http::get($this->apiUrl . '/' . $id);

        if (!$response->successful()) {
            throw new \Exception($response->json('errors'));
        }

        $data = $response->json(['data']);
        $mitraDTO = new MitraDTO($data);

        $mitraEntity = new MitraEntity(
            $mitraDTO->id,
            $mitraDTO->sobat_id,
            $mitraDTO->nama,
            $mitraDTO->jenis_kelamin,
            $mitraDTO->email,
            $mitraDTO->posisi
        );

        return $mitraEntity;
    }

    public function getBySobatId($id): object
    {
        $request = [
            'sobat_id' => $id
        ];

        $response = Http::post($this->apiUrl . '/sobat-id', $request);

        if (!$response->successful()) {
            throw new \Exception($response->json('errors'));
        }

        $data = $response->json(['data']);
        $mitraDTO = new MitraDTO($data);

        $mitraEntity = new MitraEntity(
            $mitraDTO->id,
            $mitraDTO->sobat_id,
            $mitraDTO->nama,
            $mitraDTO->jenis_kelamin,
            $mitraDTO->email,
            $mitraDTO->posisi
        );

        return $mitraEntity;
    }
}
