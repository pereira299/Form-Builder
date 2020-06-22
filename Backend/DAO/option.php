<?php
namespace Dao;

Class Option{
    protected $id;
    protected $nome;
    protected $quest_id;

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->nome;
    }

    public function getQuest(){
        return $this->quest_id;
    }

    public function setId(int $id){
        $this->id = $id;
    }

    public function setName(String $nome){
        $this->nome = $nome;
    }

    public function setQuest(int $quest){
        $this->quest_id = $quest;
    }

}




?>