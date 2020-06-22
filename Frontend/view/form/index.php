
<?php  
    $url = explode("/", ($_SERVER["REQUEST_URI"]));
    $id = $url[4];

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
    

    $server = 'http://192.168.15.180/form/answer/'.$id;
    $res = file_get_contents($server, false, $context);
    $res = json_decode($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" media="screen" href="/../../assets/css/style.css" />
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
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
    <script src="/../../assets/js/main.js"></script>
</head>
<body>
    <div class="container">
        <div class="card card-body">
            <table class="table col-lg-12">
                <thead>
                    <tr>
                        <?php
                            for ($i=0; $i < sizeof($data->questions); $i++) { 
                                $item = $data->questions[$i];
                                echo "<th scope='col'>". $item->title ."</th>";
                            }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $qtdd = sizeof($data->questions);
                        $qtddRes = sizeof($res)/$qtdd;
                        for ($i=0; $i < $qtddRes; $i++) { 
                            echo "<tr>";
                            for ($o=0; $o < $qtdd; $o++) { 
                                $count = ($i * $qtdd) + $o;
                                $item = $res[$count];

                                echo "<td>".$item->text."</td>";
                            }
                            
                            echo "</tr>";
                        }

                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>