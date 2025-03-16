<?php

namespace App\Models\RepositorySQL;

use Illuminate\Support\Facades\DB;

class PostService extends PostRepositorySQL
{
    protected PostRepositorySQL $postRepositorySQL;
    function __construct(PostRepositorySQL $postRepositorySQL)
    {
        $this->postRepositorySQL = $postRepositorySQL;
    }
   
}
