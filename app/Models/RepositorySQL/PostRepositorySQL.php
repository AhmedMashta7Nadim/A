<?php

namespace App\Models\RepositorySQL;

use App\Models\DTO\PostDTO;
use App\Models\Post;
use App\Models\Repo\IServicesRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class PostRepositorySQL implements IServicesRepositorySQL
{

    public function getNameUser($id)
    {
            $table = DB::select("select name from users where id=?", [$id]);
           return $table;
    }

    public function getAllSql()
    {
        $postTable = DB::select("select * from posts WHERE IsActive=true");
        return array_map(fn($post) =>
        PostDTO::fromArray((array)$post), $postTable);
    }
    public function getByIdSql($Id)
    {
        $postById = DB::select("select * from posts where id=? AND IsActive=true",[$Id]);
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
    public function UpdateSql($Id, $column, $data): ?PostDTO
    {
        $allowedColumns = ['title', 'content'];
        if (!in_array($column, $allowedColumns)) {
            throw new \InvalidArgumentException("العمود المحدد غير صالح.");
        }

        $post = Post::find($Id);
        if (!$post) {
            return null;
        }

        $post->$column = $data;
        $post->save();

        return PostDTO::fromArray($post->toArray());
    }
    public function SoftDelete($Id): ?PostDTO
    {
        $post = Post::find($Id);
        if (!$post) {
            return null;
        }
        $post->IsActive = false;
        $post->save();

        return PostDTO::fromArray($post->toArray());
    }

}
