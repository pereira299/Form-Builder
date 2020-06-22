<?php
namespace Config;
require 'vendor/autoload.php';
 
// Using Medoo namespace
use Medoo\Medoo;
class Database {
// Initialize
    private $database;

    function getDb(){
        return new Medoo([
            'database_type' => 'mysql',
            'database_name' => 'formulario',
            'server' => 'localhost',
            'username' => 'root',
            'password' => ''
        ]);
    }
}
?>