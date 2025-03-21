<?php

namespace App\Models\RepositorySQL;

use App\Events\AlertEvent;
use App\Models\Commint;
use App\Models\Repo\IServicesRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class CommintRepositorySQL implements IServicesRepositorySQL{
    public function getAllSql(){
        $select=DB::select("select * from Commints where IsActive=true");
        broadcast(new AlertEvent($select))->toOthers();
        return $select;
    }

    public function getByIdSql($Id){
        $selectWhereId=DB::selectOne("select * from Commints where IsActive=true AND id=?",[$Id]);
        return $selectWhereId;
    }
    public function AddSql(array $data)
{
    $inserted = DB::table('Commints')->insert([
        'content' => $data['content'],
        'UserId' => $data['UserId'],
        'PostId' => $data['PostId'],
    ]);

    if ($inserted) {
        $commint = DB::table('Commints')
        ->where('UserId', $data['UserId'])
        ->where('PostId', $data['PostId'])
       ->first();

        return $commint;
    }

    return null;  
}

    
    public function UpdateSql($Id,$columen,$data){

    }
    public function SoftDelete($Id){

    }
}