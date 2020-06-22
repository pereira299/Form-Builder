<?php
namespace Controller;
use Respect\Validation\Validator;
use Model\QuestionTable;
use Dao\Question;
use Exception;

require_once __DIR__ ."/../DAO/question.php";
require_once __DIR__ ."/../Model/questionsTable.php";
require_once "optionController.php";

class QuestionController{
    public function add(Object $data){
        $valid = $this->validator($data);
        if(!is_bool($valid)){
            return $valid;
        }
        try{
        $question = new Question();
        $question->setTitle($data->title);
        $question->setType($data->type);
        $question->setForm($data->form);
        $question->setpos($data->pos);
        $question->setRequire($data->require);
        
        $table = new QuestionTable();
        $questId = intval($table->insert($question));
        }catch(Exception $e){
            return false;
        }
        if(is_numeric($questId)){
            if(sizeof($data->options) > 0){
                return $this->setOptions($questId, $data->options);
            }else{
                return 0;
            }
        }else{
            return false;
        }
    }

    public function getAll(){
        $table = new QuestionTable();
        return $table->select();
    }

    public function getByForm(int $id){
        $table = new QuestionTable();
        $where = [
            ["form_id", "=", $id]
        ];
        $questions = $table->select([], $where);
        $res = [];
        foreach ($questions as $quest) {
            $quest = (object) $quest;

            $quest->options = $this->getOptions($quest->id);
            array_push($res, $quest);
        }

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
        $table = new QuestionTable();
        return $table->update($data, $where);
    }

    public function remove(int $id){
        $table = new QuestionTable();
        return $table->delete("id", $id);
    }

    public function removeByForm(int $id){
        $table = new QuestionTable();
        $quests = $this->getByForm($id);
        foreach ($quests as $quest) {
            $quest = (object) $quest;
            $this->rollback($quest->id);
        }
    }
    private function validator(Object $data){
        if(!is_null($data->title)){
            $check = validator::stringType()->validate($data->title);
            if(!$check){
                return "o valor ". $data->title ." é invalido";
            }
        }else{
            return "valor nulo é invalido";
        }
        
        if(!is_null($data->form)){
            $check = validator::number()->validate($data->form);
            if(!$check){
                return "o valor ". $data->form ." é invalido";
            }
        }else{
            return "valor nulo é invalido";
        }

        if(!is_null($data->type)){
            $check = validator::stringType()->validate($data->type);
            if(!$check){
                return "o valor ". $data->type ." é invalido";
            }
        }else{
            return "valor nulo é invalido";
        }

        if(!is_null($data->pos)){
            $check = validator::number()->validate($data->pos);
            if(!$check){
                return "o valor ". $data->pos ." é invalido";
            }
        }else{
            return "valor nulo é invalido";
        }
        return true;

    }
    private function rollback($id){
        $question = new OptionController();
        $question->removeByQuest($id);

        $this->remove($id);
    }

    private function setOptions($questId, $options){
        foreach ($options as $option) {
            $data = (object) [
                "name"=>$option,
                "quest"=>$questId
            ];
            
            $op = new OptionController();
            $id = $op->add($data);
            if(!is_numeric($id)){
                $this->rollback($questId);
                return false;
            }
        }
        return 0;
    }

    private function getOptions($questId){
        $op = new OptionController();
        return $op->getByQuest($questId);
    }
}
?>