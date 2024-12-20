<?php

namespace App\Services;

interface BasicRequestServiceInterface
{
    public function getAll(): array;
    public function getById($id): object;
    public function create($data): string;
    public function update($id, $data): string;
    public function delete($id): string;
}
