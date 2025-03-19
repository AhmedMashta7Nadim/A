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


    
}
