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



//    public function AddSql(array $data): ?UserDTO
//    {
//        $query = "INSERT INTO users (`name`, `email`, `password`) VALUES(?, ?, ?)";
//        $inserted = DB::insert($query, [
//            $data['name'],
//            $data['email'],
//            bcrypt($data['password'])
//        ]);
//        if ($inserted) {
//            $id = DB::getPdo()->lastInsertId();
//            return $this->getByIdSql($id);
//        }
//        return null;
//    }
    public function AddSql(array $data): ?UserDTO
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        return $user ? UserDTO::fromArray($user->toArray()) : null;
    }
    public function UpdateSql($Id, $column, $data): ?UserDTO
    {
        $allowedColumns = ['name', 'email', 'password'];
        if (!in_array($column, $allowedColumns)) {
            throw new \InvalidArgumentException("العمود المحدد غير صالح.");
        }

        $user = User::find($Id);
        if (!$user) {
            return null;
        }

        if ($column === 'password') {
            $user->$column = bcrypt($data);
        } else {
            $user->$column = $data;
        }

        $user->save();

        return UserDTO::fromArray($user->toArray());
    }




//    public function UpdateSql($Id, $columen, $data): ?UserDTO
//    {
//
//        $query = "UPDATE users SET `$columen`=? WHERE id=`$Id`";
//        $updated = DB::update($query, [
//            $data['name'],
//            $data['email'],
//            $Id
//        ]);
//        return $updated ? $this->getByIdSql($Id) : null;
//    }
//

    public function SoftDelete($Id): ?UserDTO
    {
        $user = User::find($Id);
        if (!$user) {
            return null;
        }

        $user->IsActive = false;
        $user->save();

        return UserDTO::fromArray($user->toArray());
    }


//    public function SoftDelete($Id): ?UserDTO
//    {
//        $quere = "UPDATE users SET IsActive=false WHERE id=`$Id`";
//        return $quere ? $this->getByIdSql($Id) : null;
//    }
}
