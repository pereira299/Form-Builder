<?php
namespace Dao;

class Form{
    private $id;
    private $name;
    private $desc;

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    public function getDesc(){
        return $this->desc;
    }

    public function setId(int $id){
        $this->id = $id;
    }
    
    public function setName(String $name){
        $this->name = $name;
    }

    public function setDesc(String $desc){
        $this->desc = $desc;
    }

}




?>