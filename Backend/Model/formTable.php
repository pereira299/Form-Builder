<?php
namespace Model;
use Config\Database;
use Dao\Form;

require_once __DIR__ ."/../DAO/form.php";
require_once __DIR__ ."/../config/database.php";

class FormTable{
    public function insert(Form $res){
        $banco = new Database();
        $db = $banco->getDb();
        $data = $db->insert('forms', [
            'name'=> $res->getName(),
            'desc' => $res->getDesc()
        ]);
        $erro = $db->error();
        if(is_null($erro[1])){
            return $db->id();
        }else{
            return false;
        }
    }
    public function select(Array $cols = [], Array $where = []){
        $banco = new Database();
        $db = $banco->getDb();
        if(!is_array($cols) || !is_array($where)){
            return false;
        }
        
        for ($i=0; $i < sizeof($cols); $i++) { 
            $item = $cols[$i];
            if(!is_string($item)){
                return false;
            }
        }
        
        
        if(sizeof($where) == 0){
            if(sizeof($cols) == 0){
                $data = $db->select("forms", "*");
            }else{
                $data = $db->select("forms", $cols);
            }
        }else{
            $where = $this->where($where);
            if($where == false){
                return false;
            }
            if(sizeof($cols) == 0){
                $data = $db->select("forms", "*", $where);
            }else{
                $data = $db->select("forms", $cols, $where);
            }
        }
        $erro = $db->error();
        
        if(is_null($erro[1])){
            return $data;
        }else{
            return false;
        }
        
    }
    public function update($cols, $where){
        $banco = new Database();
        $db = $banco->getDb();
        if(sizeof($where) == 0){
            $data = $db->update("forms", $cols);
        }else{
            $where = $this->where($where);
            if($where == false){
                return false;
            }
            $data = $db->update("forms", $cols, $where);
        }

        $erro = $db->error();
        if(is_null($erro[1])){
            return $data;
        }else{
            return false;
        }
    }
    public function delete(String $col, int $value){
        $banco = new Database();
        $db = $banco->getDb();
        $where = [$col => $value];
        $data = $db->delete("forms", $where);

        $erro = $db->error();
        
        if(is_null($erro[1])){
            return $data;
        }else{
            return false;
        }
    }

    private function where($where){
        $data = [];
        if(!is_array($where)){
            return false;
        }
        for ($i=0; $i < sizeof($where); $i++) { 
            $cond = $where[$i];
            if(!is_array($cond) || sizeof($cond) != 3){
                return false;
            }
            $name = $cond[0] . "[".$cond[1]."]";
            
            $data[$name] = $cond[2];
        }
        return $data;
    }
}

?>