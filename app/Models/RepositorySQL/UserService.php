<?php

namespace App\Models\RepositorySQL;

use Illuminate\Support\Facades\DB;

class UserService extends UserRepositorySQL
{
    protected $userRepository;

    public function __construct(UserRepositorySQL $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getNameUser($id)
    {
        $table = DB::selectOne("select name from users where IsActive=true And id=?", [$id]);
        return $table;
    }
    public function getDataUserAndPost()
    {
        $table = DB::select('
    select u.name,p.title,p.content,p.UserId from users as u 
                    INNER JOIN posts as p on u.id=p.UserId
                    where u.IsActive=true
    ');
        return $table;
    }
}
