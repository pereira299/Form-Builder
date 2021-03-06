<?php
namespace Model;
use Config\Database;
use Dao\Answer;

class AnswerTable{
    public function insert(Answer $res){
        $banco = new Database();
        $db = $banco->getDb();
        $data = $db->insert('answers', [
            'text'=> $res->getText(),
            'question_id' => $res->getQuestion(),
            'user_id' => $res->getUser(),
            'form_id' => $res->getForm()
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
        
        if(sizeof($cols) == 0){
            $cols = "*";
        }else{
            for ($i=0; $i < sizeof($cols); $i++) { 
                $item = $cols[$i];
                if(!is_string($item)){
                    return false;
                }
            }
        }
        
        if(sizeof($where) == 0){
            $data = $db->select("answers", $cols);
        }else{
            $where = $this->where($where);
            if($where == false){
                return false;
            }
            $data = $db->select("answers", $cols, $where);
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
            $data = $db->update("answers", $cols);
        }else{
            $where = $this->where($where);
            if($where == false){
                return false;
            }
            $data = $db->update("answers", $cols, $where);
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
        $data = $db->delete("answers", $where);

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