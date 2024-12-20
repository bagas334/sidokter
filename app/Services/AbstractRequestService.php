<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

abstract class AbstractRequestService implements BasicRequestServiceInterface
{
    protected $apiUrl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    abstract public function getAll(): array;

    abstract public function getById($id): object;

    /**
     * @throws \Exception
     */
    public function create($data): string
    {
        $response = Http::post($this->apiUrl, $data);

        if (!$response->successful()) {
            throw new \Exception($response->json('errors'));
        }

        $result = [
            'status' => $response->status(),
            'message' => $response->json('message')
        ];

        return json_encode($result);
    }

    /**
     * @throws \Exception
     */
    public function update($id, $data): string
    {
        $response = Http::put($this->apiUrl . '/' . $id, $data);

        if (!$response->successful()) {
            throw new \Exception($response->json('errors'));
        }

        $result = [
            'status' => $response->status(),
            'message' => $response->json('message')
        ];

        return json_encode($result);
    }

    /**
     * @throws \Exception
     */
    public function delete($id): string
    {
        $response = Http::delete($this->apiUrl . '/' . $id);

        if (!$response->successful()) {
            throw new \Exception($response->json('errors'));
        }

        $result = [
            'status' => $response->status(),
            'message' => $response->json('message')
        ];

        return json_encode($result);
    }
}
