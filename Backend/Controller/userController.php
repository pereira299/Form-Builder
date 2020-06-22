<?php
namespace Controller;
use Respect\Validation\Validator;
use Model\UserTable;
use Dao\User;

require_once __DIR__ ."/../DAO/user.php";
require_once __DIR__ ."/../Model/usersTable.php";

class UserController{
    public function add(){
        

        $table = new UserTable();
        return $table->insert();
    }

    public function getAll(){
        $table = new UserTable();
        return $table->select();
    }

    public function getById(int $id){
        $table = new UserTable();
        $where = [
            ["id", "=", $id]
        ];
        return $table->select([], $where);
    }

    public function change(Object $data, int $id){
        $valid = $this->validator($data);
        if(!is_bool($valid)){
            return $valid;
        }
        $where = [
            ["id", "=", $id]
        ];
        $table = new UserTable();
        return $table->update($data, $where);
    }

    public function remove(int $id){
        $table = new UserTable();
        return $table->delete("id", $id);
    }

    private function validator(Object $data){

        if(!is_null($data->id)){
            $check = validator::number()->validate($data->id);
            if(!$check){
                return "o valor ". $data->id ." é invalido";
            }
        }
        return true;
    }
}
?>