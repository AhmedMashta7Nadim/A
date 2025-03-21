<?php

namespace App\Models\RepositorySQL;

use Illuminate\Support\Facades\DB;

class CommintService extends CommintRepositorySQL
{
    protected CommintRepositorySQL $CommintRepository;

    public function __construct(CommintRepositorySQL $CommintRepository)
    {
        $this->CommintRepository = $CommintRepository;
    }

    public function getCommintWithUser($id){
        $table = DB::select('
             SELECT c.*, p.UserId,u.name
            FROM Commints AS c
            INNER JOIN posts AS p ON p.id = c.PostId
            INNER JOIN users AS u ON u.id=c.UserId
            WHERE c.IsActive = true AND c.PostId = :id
        ', ['id' => $id]);
        return $table;
    }
    
    

    
}
