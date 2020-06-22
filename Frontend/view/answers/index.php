<?php  
    $url = explode("/", ($_SERVER["REQUEST_URI"]));
    $id = $url[3];

    $server = 'http://192.168.15.180/form/'.$id;

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'GET'
        )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($server, false, $context);
    $data = json_decode($result);
    

    $server = 'http://192.168.15.180/user';
    $result = file_get_contents($server, false, $context);
    $user = intVal($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" media="screen" href="/../../assets/css/style.css" />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/all.min.js" 
        integrity="sha256-HkXXtFRaflZ7gjmpjGQBENGnq8NIno4SDNq/3DbkMgo=" 
        crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/../../assets/js/main.js"></script>
    <script src="/../../assets/js/saveResp.js"></script>
    <script>
        <?= "window.sessionStorage.setItem('user',". $user . ");"; ?>
        function setSlider(id, min, max){
            let med = parseInt((max - min)/4);
            let v1 = med, v2 = med*3;
            $( "#slider"+id ).slider({
                range: true,
                min: min,
                max: max,
                values: [ v1, v2 ],
                slide: function( event, ui ) {
                    $( "#amount"+id ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
                }
            });
        }
    </script>
</head>
<body>
<a class="row col-lg-4" href="http://localhost:8080/">
    <i class="fas black fa-arrow-left fa-2x m-2"></i>
    <p class="voltar black p-0">Voltar</p>
</a>
<div class="col-lg-8 offset-lg-2">
    <div class="card card-body col-lg-12 mb-3 shadow-sm">
        <h2 class="text-center"><?= $data->name?></h2>
        <p class="text-center p-0"><?= $data->desc?></p>
    </div>
    <?php
        for ($i=0; $i < sizeof($data->questions); $i++) { 
            $item = $data->questions[$i];
            echo "<div class='col-lg-12 card card-body mb-3 shadow quest' id='question".$item->id."'>
            <h4 id='title".$item->id."'>".$item->title."</h4>";
            
            if($item->require == 0){
                echo "<div id='item".$item->id."'>";
            }else{
                echo "<div id='item".$item->id."' class='required'>";
            }
            
            switch($item->type){
                case"text":
                    echo "<input type='text' class='form-control col-lg-6' placeholder='Resposta...'>";
                    break;
                case"textarea":
                    echo "<textarea class='form-control col-lg-6' placeholder='Resposta...'></textarea>";
                    break;
                case"select":
                    
                    echo "<select class='form-control col-lg-6'>
                    <option value=''>Selecione...</option>";
                    foreach($item->options as $option){
                        echo "<option value='".$option->name."'>".$option->name."</option>";
                    }
                    echo "</select>";
                    break;
                case"checkbox":
                    foreach($item->options as $option){
                        echo "<label class='row col-lg-6'><input type='checkbox' class='form-control-sm mr-2'><p>".$option."</p></label>";
                    }
                    break;
                case"radio":
                    
                    foreach($item->options as $option){
                        echo "<label class='row col-lg-6'><input type='radio' name='radio".$item->id."' class='form-control-sm mr-2'><p>".$option->name."</p></label>";
                    }
                    break;
                case"date":
                    echo "<input type='date' class='form-control col-lg-6'>";
                    break;
                case"datetime":
                    echo "<input type='date' class='form-control mb-2 col-lg-6'><input type='time' class='form-control'>";
                    break;
                case"time":
                    echo "<input type='time' class='form-control col-lg-6'>";
                    break;
                case"number":
                    echo "<input type='number' class='form-control col-lg-6'>";
                    break;
                case"color":
                    echo "<input type='color' class='form-control col-lg-6'>";
                    break;
                case"range":
                    echo "<p>".
                    "<input type='text' id='amount".$item->id."' readonly style='border:0; color:#17a2b8; font-weight:bold;'>".
                    "</p>".
                    "<div id='slider".$item->id."' class='col-lg-6'></div>";
                    
                    echo "<script type='text/javascript'>",
                    "setSlider('".$item->id."', ". $item->options[0]->name .", ". $item->options[1]->name .");",
                    "</script>";
                    break;
                
            }

            echo"</div></div>";
        }
    ?>
    <button class="btn btn-info btn-block mb-4" onclick="salvar()">Salvar</button>
</div>
</body>
</html>