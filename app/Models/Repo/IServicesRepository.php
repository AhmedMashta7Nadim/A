<?php

namespace App\Models\Repo;

use Illuminate\Http\JsonResponse;

interface IServicesRepository
{
    public function getAll(): JsonResponse;
    public function getById($id): JsonResponse;
    public function add(array $data): JsonResponse;
    public function update($id, array $data): JsonResponse;
    public function deleteSoft($id): JsonResponse;
}
