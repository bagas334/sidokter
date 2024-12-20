<?php

namespace App\Services;

use App\DTOs\KegiatanDTO;
use App\Entities\KegiatanEntity;
use Illuminate\Support\Facades\Http;

class KegiatanService extends AbstractRequestService
{
    public function __construct()
    {
        parent::__construct(config('services.api.base_url') . '/kegiatan');
    }

    public function getAll(): array
    {
        $response = Http::get($this->apiUrl);

        if (!$response->successful()) {
            throw new \Exception($response->json('errors'));
        }

        $data = $response->json(['data']);
        $kegiatanEntities = [];

        foreach ($data as $item) {
            $kegiatanDTO = new KegiatanDTO($item);

            $kegiatanEntity = new KegiatanEntity(
                $kegiatanDTO->id,
                $kegiatanDTO->nama,
                $kegiatanDTO->asalFungsi,
                $kegiatanDTO->periode,
                $kegiatanDTO->tanggalMulai,
                $kegiatanDTO->tanggalAkhir,
                $kegiatanDTO->target,
                $kegiatanDTO->satuan,
                $kegiatanDTO->hargaSatuan
            );

            $kegiatanEntities[] = $kegiatanEntity;
        }
        return $kegiatanEntities;
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
        $kegiatanDTO = new KegiatanDTO($data);

        $kegiatanEntity = new KegiatanEntity(
            $kegiatanDTO->id,
            $kegiatanDTO->nama,
            $kegiatanDTO->asalFungsi,
            $kegiatanDTO->periode,
            $kegiatanDTO->tanggalMulai,
            $kegiatanDTO->tanggalAkhir,
            $kegiatanDTO->target,
            $kegiatanDTO->satuan,
            $kegiatanDTO->hargaSatuan
        );

        return $kegiatanEntity;
    }

    public function getByNama($nama)
    {
        $request = [
            'nama' => $nama
        ];

        $response = Http::post($this->apiUrl . '/nama', $request);

        if (!$response->successful()) {
            throw new \Exception($response->json('errors'));
        }

        $data = $response->json(['data']);
        $kegiatanDTO = new KegiatanDTO($data);

        $kegiatanEntity = new KegiatanEntity(
            $kegiatanDTO->id,
            $kegiatanDTO->nama,
            $kegiatanDTO->asalFungsi,
            $kegiatanDTO->periode,
            $kegiatanDTO->tanggalMulai,
            $kegiatanDTO->tanggalAkhir,
            $kegiatanDTO->target,
            $kegiatanDTO->satuan,
            $kegiatanDTO->hargaSatuan
        );

        return $kegiatanEntity;
    }
}
