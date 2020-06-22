<?php
require_once __DIR__ ."/../Controller/formController.php";
require_once __DIR__ ."/../Controller/answerController.php";
require_once __DIR__ ."/../Controller/userController.php";
use Controller\AnswerController;
use Controller\FormController;
use Controller\OptionController;
use Controller\QuestionController;
use Controller\UserController;
require_once __DIR__ . '/../vendor/autoload.php';

$klein = new \Klein\Klein();
$request = \Klein\Request::createFromGlobals();

//Salvar novo formulario
$klein->respond('POST', '/form/add', function ($req,$res) {
    $form = new FormController();
    $data = json_decode($req->body());
    return $form->add($data);
});

//Todas os formularios
$klein->respond('GET', '/form/all', function ($req,$res) {
    $form = new FormController();
    return json_encode($form->getAll());
});

$klein->respond('GET', '/user', function ($req,$res) {
    $user = new UserController();
    return $user->add();
});

$klein->respond('POST', '/form/name', function ($req,$res) {
    $form = new FormController();
    $data = json_decode($req->body());
    return json_encode($form->getByName($data->name));
});

//selecionar formularios
$klein->respond('GET', '/form/[:id]', function ($req,$res) {
    $form = new FormController();
    $id = intval($req->id);
    return json_encode($form->getById($id));
});

//Deletar formulario
$klein->respond('GET', '/form/remove/[:id]', function ($req,$res) {
    $form = new FormController();
    $id = intval($req->id);
    return json_encode($form->rollback($id));
});

//Responder formularios
$klein->respond('POST', '/answer/form/[:id]', function ($req,$res) {
    $answer = new AnswerController();
    $data = json_decode($req->body());
    $data->form = $req->id;
    $r = $answer->addAll($data);
    return $r;
});

//Ver respostas do formulario
$klein->respond('GET', '/form/answer/[:id]', function ($req,$res) {
    $resp = new AnswerController();
    $id = intval($req->id);
    return json_encode($resp->getByForm($id));
    
});

$klein->dispatch($request);

?>