<?php
namespace Controller;
use Respect\Validation\Validator;
use Controller\QuestionController;
use Model\FormTable;
use Dao\Form;
use Exception;

require_once __DIR__ ."/../DAO/form.php";
require_once __DIR__ ."/../Model/formTable.php";
require_once "questionController.php";

class FormController{
    public function add(Object $data){
        $valid = $this->validator($data);
        if(!is_bool($valid)){
            return $valid;
        }
        $form = new Form();
        $form->setName($data->name);
        $form->setDesc($data->desc);
        $table = new FormTable();
        $formId = intval($table->insert($form));
        if(is_numeric($formId)){
            return $this->setQuestions($formId, $data->questions);
        }else{
            return false;
        }
    }

    public function getAll(){
        $table = new FormTable();
        return $table->select([],[]);
    }

    public function getById(int $id){
        $table = new FormTable();
        $where = [
            ["id", "=", $id]
        ];
        $form =  $table->select([], $where);
        if(sizeof($form) > 0){
            $form = (object) $form[0];
            $form->questions = $this->getQuestions($form->id);

            return $form;
        }else{
            return false;
        }

    }

    public function getByName(String $name){
        $table = new FormTable();
        $where = [
            ["name", "~", $name]
        ];
        $form =  $table->select([], $where);
        return $form;

    }
    public function change(Object $data, int $id){
        $valid = $this->validator($data);
        if(!is_bool($valid)){
            return $valid;
        }
        $where = [
            ["id", "=", $id]
        ];
        $table = new FormTable();
        return $table->update($data, $where);
    }

    private function remove(int $id){
        $table = new FormTable();
        return $table->delete("id", $id);
    }

    private function validator(Object $data){
        
        if(!is_null($data->name)){
            $check = validator::stringType()->validate($data->name);
            if(!$check){
                return "o valor ". $data->name ." é invalido";
            }
        }
        
        if(!is_null($data->desc)){
            $check = validator::stringType()->validate($data->desc);
            if(!$check){
                return "o valor ". $data->desc ." é invalido";
            }
        }
        return true;
    }

    public function rollback($id){
        $question = new QuestionController();
        $question->removeByForm($id);

        $this->remove($id);
    }

    private function setQuestions($formId, $questions){
        foreach ($questions as $quest) {
            try{
            $quest->form = $formId;
            $question = new QuestionController();
            $id = $question->add($quest);
            }catch(Exception $e){
                $this->rollback($formId);
                return false;
            }
            if(!is_numeric($id)){
                $this->rollback($formId);
                return false;
            }
        }
        return true;
    }

    private function getQuestions($formId){
        $question = new QuestionController();
        return $question->getByForm($formId);
    }
}
/*
{
    nome:String,
    desc:String, 
    questions:[
        {
            title:String,
            type: String,
            pos: int,
            option:[
                String
            ]
        }
    ]
}

{
    forms:[
        {
            name:String,
            descion: int
        }
    ]
}*/
?>