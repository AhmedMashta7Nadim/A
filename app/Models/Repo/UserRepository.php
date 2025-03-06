<?php

namespace App\Models\Repo;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends ServicesRepository
{

    public function __construct(User $user)
    {
        parent::__construct($user); 
    }
}
