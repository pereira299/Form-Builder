<?php
namespace Dao;

Class User{
    protected $id;
    
    public function getId(){
        return $this->id;
    }

    public function setId(int $id){
        $this->id = $id;
    }
}

?>