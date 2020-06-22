<?php
namespace Controller;
use Respect\Validation\Validator;
use Model\OptionTable;
use Dao\Option;

require_once __DIR__ ."/../DAO/option.php";
require_once __DIR__ ."/../Model/optionsTable.php";

class OptionController{
    public function add(Object $data){
        $valid = $this->validator($data);
        if(!is_bool($valid)){
            return $valid;
        }
        $option = new Option();
        $option->setName($data->name);
        $option->setQuest($data->quest);

        $table = new OptionTable();
        return $table->insert($option);
    }

    public function getAll(){
        $table = new OptionTable();
        return $table->select();
    }

    public function getByQuest(int $id){
        $table = new OptionTable();
        $where = [
            ["question_id", "=", $id]
        ];
        $op = $table->select([], $where);

        return $op;
    }

    public function change(Object $data, int $id){
        $valid = $this->validator($data);
        if(!is_bool($valid)){
            return $valid;
        }
        $where = [
            ["id", "=", $id]
        ];
        $table = new OptionTable();
        return $table->update($data, $where);
    }

    public function remove(int $id){
        $table = new OptionTable();
        return $table->delete("id", $id);
    }

    public function removeByQuest(int $id){
        $table = new OptionTable();
        return $table->delete("quest_id", $id);
    }

    private function validator(Object $data){
        
        if(!is_null($data->name)){
            $check = validator::stringType()->validate($data->name);
            if(!$check){
                return "o valor ". $data->name ." é invalido";
            }
        }
        
        if(!is_null($data->quest)){
            $check = validator::number()->validate($data->quest);
            if(!$check){
                return "o valor ". $data->quest ." é invalido";
            }
        }
        return true;
    }
}
?>