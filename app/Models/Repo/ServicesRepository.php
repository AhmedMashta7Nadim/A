<?php

namespace App\Models\Repo;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ServicesRepository implements IServicesRepository
{
    private Model $model;

    private  $data;

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->data = DB::table($this->model->getTable());
    }



    public function getAll(): JsonResponse
    {
        //$data = $this->model->where('isActive', true)->get();
        try {
        $data = $this->data->where('isActive', true)->get();
            return response()->json(["data" => $data], 200);
        } catch (Exception $exp) {
            return response()->json(["error" => $exp->getMessage()], 404);
        }
    }

    public function getById($id): JsonResponse
    {
            // $data->findOrFail($id)->get();
        try {
            $data = $this->model->findOrFail($id);
            return response()->json(["Data" => $data], 200);
        } catch (Exception $exp) {
            return response()->json(["errors" => $exp->getMessage()], 404);
        }
    }

    public function add( $data): JsonResponse
    {
        try {
            $request = $this->model->create($data);
            return response()->json(["data" => $request], 201);
        } catch (Exception $exp) {
            return response()->json(["error" => $exp->getMessage()], 404);
        }
    }

    public function update($id, array $data): JsonResponse
    {
        try {
            $find = $this->model->findOrFail($id);
            $find->update($data);
            return response()->json(["updated" => $find], 200);
        } catch (Exception $exp) {
            return response()->json(["error" => $exp->getMessage()], 404);
        }
    }

    public function deleteSoft($id): JsonResponse
    {
        try {
            $deleted_soft = $this->model->findOrFail($id);
            $deleted_soft->isActive = false;
            $deleted_soft->save();
            return response()->json(["message" => "Deleted Successfully", "data" => $deleted_soft], 204);
        } catch (Exception $exp) {
            return response()->json(["error" => $exp->getMessage()], 404);
        }
    }
}
