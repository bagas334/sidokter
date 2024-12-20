<?php

namespace App\Services;

use App\DTOs\PegawaiDTO;
use App\Entities\PegawaiEntity;
use Illuminate\Support\Facades\Http;

class PegawaiService extends AbstractRequestService
{
    public function __construct()
    {
        parent::__construct(config('services.api.base_url') . '/pegawai');
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
        $pegawaiEntities = [];

        foreach ($data as $item) {
            $pegawaiDTO = new PegawaiDTO($item);

            $pegawaiEntity = new PegawaiEntity(
                $pegawaiDTO->id,
                $pegawaiDTO->nip,
                $pegawaiDTO->nipBps,
                $pegawaiDTO->nama,
                $pegawaiDTO->alias,
                $pegawaiDTO->jabatan,
                $pegawaiDTO->golongan,
                $pegawaiDTO->status
            );

            $pegawaiEntities[] = $pegawaiEntity;
        }

        return $pegawaiEntities;
    }

    public function getById($id): object
    {
        $response = Http::get($this->apiUrl . '/' . $id);

        if (!$response->successful()) {
            throw new \Exception($response->json('errors'));
        }

        $data = $response->json(['data']);
        $pegawaiDTO = new PegawaiDTO($data);

        $pegawaiEntity = new PegawaiEntity(
            $pegawaiDTO->id,
            $pegawaiDTO->nip,
            $pegawaiDTO->nipBps,
            $pegawaiDTO->nama,
            $pegawaiDTO->alias,
            $pegawaiDTO->jabatan,
            $pegawaiDTO->golongan,
            $pegawaiDTO->status
        );

        return $pegawaiEntity;
    }

    public function getByNip($nip): object
    {
        $request = [
            'nip' => $nip
        ];

        $response = Http::post($this->apiUrl . '/nip', $request);

        if (!$response->successful()) {
            throw new \Exception($response->json('errors'));
        }

        $data = $response->json(['data']);
        $pegawaiDTO = new PegawaiDTO($data);

        $pegawaiEntity = new PegawaiEntity(
            $pegawaiDTO->id,
            $pegawaiDTO->nip,
            $pegawaiDTO->nipBps,
            $pegawaiDTO->nama,
            $pegawaiDTO->alias,
            $pegawaiDTO->jabatan,
            $pegawaiDTO->golongan,
            $pegawaiDTO->status
        );

        return $pegawaiEntity;
    }
}
