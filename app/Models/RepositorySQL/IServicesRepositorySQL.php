<?php

namespace App\Models\RepositorySQL;

use Illuminate\Database\Eloquent\Model;

interface IServicesRepositorySQL 
{
    public function getAllSql();
    public function getByIdSql($Id);
    public function AddSql(array $data);
    public function UpdateSql($Id,$columen,$data);
    public function SoftDelete($Id);
}
