<?php

namespace App\Models\RepositorySQL;

use App\Models\DTO\UserDTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserRepositorySQL implements IServicesRepositorySQL
{
    public function getAllSql()
    {
        $usersTable = DB::select('select * from users where IsActive=true');
        return array_map(fn($usersTable) => UserDTO::fromArray((array) $usersTable), $usersTable);
    }

    public function getByIdSql($Id)
    {
        $usersTable = DB::select("select * from users where id=? AND IsActive=?", [$Id, true]);
        if (empty($usersTable)) {
            return null;
        }
        return UserDTO::fromArray((array)$usersTable[0]);
    }



    public function AddSql(array $data): ?UserDTO
    {
        $query = "INSERT INTO users (`name`, `email`, `password`) VALUES(?, ?, ?)";
        $inserted = DB::insert($query, [
            $data['name'],
            $data['email'],
            bcrypt($data['password'])
        ]);
        if ($inserted) {
            $id = DB::getPdo()->lastInsertId();
            return $this->getByIdSql($id);
        }
        return null;
    }




    public function UpdateSql($Id, $columen, $data): ?UserDTO
    {

        $query = "UPDATE users SET `$columen`=? WHERE id=`$Id`";
        $updated = DB::update($query, [
            $data['name'],
            $data['email'],
            $Id
        ]);
        return $updated ? $this->getByIdSql($Id) : null;
    }
    public function SoftDelete($Id): ?UserDTO
    {
        $quere = "UPDATE users SET IsActive=false WHERE id=`$Id`";
        return $quere ? $this->getByIdSql($Id) : null;
    }
}
