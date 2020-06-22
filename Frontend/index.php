<?php
$url = 'http://192.168.15.180/form/all';

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'GET'
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Form Bulider</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/style.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js" integrity="sha256-HkXXtFRaflZ7gjmpjGQBENGnq8NIno4SDNq/3DbkMgo=" crossorigin="anonymous">
    </script>
    <script src="assets/js/main.js"></script>
</head>

<body>
    <div class="container">
        <div class="col-lg-12 row mt-2">
            <a class="btn btn-outline-info col-lg-3" href="/view/new">Novo Formulario</a>
            <input class="col-lg-3 offset-lg-5 search" type="text" placeholder="Pesquisar...">
            <button class="btn btn-light col-lg-1" onclick="search()">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <h1 class="text-center font-weight-light mb-5 mt-4" id="title">
            Formularios
        </h1>
        <div class="col-lg-12 row" id="itens">
            <?php

            if ($result !== false) {
                $start = strpos($result, "[");
                $end = strpos($result, "]") + 1;
                $result = substr($result, $start, $end);
                $result = json_decode($result);
                if(sizeof($result) == 0){
                    echo "<h3>Ainda não há nenhum formulario aqui</h3>";
                }
                foreach ($result as $item) {
                    echo "<div class='item col-lg-3 mb-2' id='item". $item->id ."'>
                        <div class='btn-group col-lg-12 px-0 mx-0'>
                            <button class='btn btn-info col-lg-10' data-toggle='collapse' href='#form" . $item->id . "' 
                            role='button' aria-expanded='false' aria-controls='form" . $item->id . "'>
                            " . $item->name . "
                            </button>
                            <button class='btn btn-info col-lg-2' id='rm" . $item->id . "' onclick='rmForm(this.id)'>
                                <i class='far fa-times-circle remove' aria-hidden='true'></i>
                            </button>
                        </div>
                        <div class='collapse' id='form" . $item->id . "'>
                            
                            <div class='card card-body'>
                            <a class='btn btn-outline-info' href='/view/answers/" . $item->id ."'>Responder</a>
                            <a class='btn btn-outline-info mt-2' href='/view/form/answers/" . $item->id ."'>Ver respostas</a>
                            </div>
                            
                        </div>
                    </div>";
                }
            } else {
                echo "<h3>Oops! Algo deu errado :(</h3>";
            }
            ?>
        </div>
    </div>
</body>

</html>