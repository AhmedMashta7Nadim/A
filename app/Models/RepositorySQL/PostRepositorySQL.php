<?php

namespace App\Models\RepositorySQL;

use App\Models\DTO\PostDTO;
use App\Models\Repo\IServicesRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostRepositorySQL implements IServicesRepositorySQL
{
    public function getAllSql()
    {
        $postTable = DB::select("select * from posts");
        return array_map(fn($post) =>
        PostDTO::fromArray((array)$post), $postTable);
    }
    public function getByIdSql($Id)
    {
        $postById = DB::select("select * from posts where id=?",[$Id]);
        if (empty($postById)) {
            return null;
        }
        return PostDTO::fromArray((array)$postById[0]);
    }
    public function AddSql(array $data)
    {
        $query = "INSERT INTO posts (`title`, `content`,`UserId`) VALUES(?, ?,?)";
        $inserted = DB::insert($query, [
            $data['title'],
            $data['content'],
            $data['UserId'],

        ]);
        if ($inserted) {
            $id = DB::getPdo()->lastInsertId();
            return $this->getByIdSql($id);
        }
        return null;
    }
    public function UpdateSql($Id, $columen, $data)
{
    $allowedColumns = ['title', 'content']; 
    if (!in_array($columen, $allowedColumns)) {
        throw new \InvalidArgumentException("العمود المحدد غير صالح.");
    }
    $query = "UPDATE posts SET `$columen` = ? WHERE id = ?";
    $updated = DB::update($query, [$data, $Id]);
    return $updated ? $this->getByIdSql($Id) : null;
}
    public function SoftDelete($Id) {}
}
