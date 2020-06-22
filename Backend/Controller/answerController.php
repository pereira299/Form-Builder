<?php
namespace Controller;
use Respect\Validation\Validator;
use Model\AnswerTable;
use Dao\Answer;

require_once __DIR__ ."/../DAO/answer.php";
require_once __DIR__ ."/../Model/answersTable.php";

class AnswerController{
    public function add(Object $data){
        $valid = $this->validator($data);
        if(!is_bool($valid)){
            return $valid;
        }
        $answer = new Answer();
        $answer->setText($data->text);
        $answer->setQuestion($data->quest);
        $answer->setForm($data->form);
        $answer->setUser($data->user);
        

        $table = new AnswerTable();
        $resId = $table->insert($answer);
        if(is_numeric($resId)){
            return true;
        }else{
            $this->rollback($data->form);
            return false;
        }
    }

    public function addAll(Object $data){
        $saved = 1;
        foreach ($data->answers as $res) {
            $res->form = $data->form;
            $save = $this->add($res);
            if(!$save){
                $saved = 0;
                break;
            }
        }
        return $saved;
    }
    public function getAll(){
        $table = new AnswerTable();
        return $table->select();
    }

    public function getByQuest(int $id){
        $table = new AnswerTable();
        $where = [
            ["question_id", "=", $id]
        ];
        return $table->select([], $where);
    }

    public function getByForm(int $id){
        $table = new AnswerTable();
        $where = [
            ["form_id", "=", $id]
        ];
        $res = $table->select([], $where);
        
        return $res;
    }

    public function change(Object $data, int $id){
        $valid = $this->validator($data);
        if(!is_bool($valid)){
            return $valid;
        }
        $where = [
            ["id", "=", $id]
        ];
        $table = new AnswerTable();
        return $table->update($data, $where);
    }

    public function remove(int $id){
        $table = new AnswerTable();
        return $table->delete("id", $id);
    }

    public function rollback($form){
        $table = new AnswerTable();
        return $table->delete("form_id", $form);
    }
    private function validator(Object $data){
        
        if(!is_null($data->text)){
            $check = validator::stringType()->validate($data->text);
            if(!$check){
                return "o valor ". $data->text ." é invalido";
            }
        }
        
        if(!is_null($data->quest)){
            $check = validator::number()->validate($data->quest);
            if(!$check){
                return "o valor ". $data->quest ." é invalido";
            }
        }

        if(!is_null($data->form)){
            $check = validator::number()->validate($data->form);
            if(!$check){
                return "o valor ". $data->form ." é invalido";
            }
        }

        if(!is_null($data->user)){
            $check = validator::number()->validate($data->user);
            if(!$check){
                return "o valor ". $data->user ." é invalido";
            }
        }
        return true;
    }
}
?>