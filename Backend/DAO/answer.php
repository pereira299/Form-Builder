<?php
namespace Dao;

Class Answer{
    protected $id;
    protected $text;
    protected $question_id;
    protected $form_id;
    protected $user_id;

    public function getId(){
        return $this->id;
    }

    public function getText(){
        return $this->text;
    }

    public function getQuestion(){
        return $this->question_id;
    }

    public function getForm(){
        return $this->form_id;
    }

    public function getUser(){
        return $this->user_id;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function setText(String $text){
        $this->text = $text;
    }

    public function setQuestion(int $question){
        $this->question_id = $question;
    }

    public function setForm(int $form){
        $this->form_id = $form;
    }

    public function setUser(int $user){
        $this->user_id = $user;
    }
}




?>