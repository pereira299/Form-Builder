<?php
namespace Dao;

Class Question{
    protected $id;
    protected $title;
    protected $type;
    protected $form_id;
    protected $pos;
    protected $require;

    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getType(){
        return $this->type;
    }

    public function getForm(){
        return $this->form_id;
    }

    public function getPos(){
        return $this->pos;
    }

    public function getRequire(){
        return $this->require;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function setTitle(String $title){
        $this->title = $title;
    }
    
    public function setType(String $type){
        $this->type = $type;
    }

    public function setPos(int $pos){
        $this->pos = $pos;
    }

    public function setForm(int $form){
        $this->form_id = $form;
    }
    
    public function setRequire(int $require){
        $this->require = $require;
    }
}




?>