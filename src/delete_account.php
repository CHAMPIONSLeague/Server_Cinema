<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrazione json
    $data = json_decode(file_get_contents("php://input"));
    
    $servername = "localhost";
    $username = "clowncinema";
    $password = "85GuHQA67pzx";
    $dbname = "my_clowncinema";

    $user = $data -> username;
    $email = $data -> email;
    
    // Creazione connessione
    $connessione = new mysqli($servername, $username, $password, $dbname);

    if($connessione->connect_error){
        die("Connection failed: " . $connessione->connect_error);
        $array = array("ris" => "Connessione Persa");
    }else{
        if(!empty($user) && !empty($email)){
            $sql = "SELECT * FROM utente WHERE username = '$user' AND email = '$email'";
            $result = $connessione -> query($sql);

            if($result -> num_rows > 0){
                //utente esistente
                $row = $result -> fetch_assoc();
                $email = $row["email"];

                //generazione token randomico che sostituirà la password
                $token = rand(0,99)."-".rand(12,87)."-".rand(7,92);

                $oggetto = "Ripristino Password";
                $txt = "
                Clicca sul link per poter confermare di voler cambiare password!

                http://clowncinema.altervista.org/src/verificaToken.php?token=".$token."&email=".$email;
                $headers = "From: clowncinema@altervista.org";

                mail($email, $oggetto, $txt, $headers);
                $array = array("ris"=>"Y");
                echo json_encode($array);
            }else{
                $array = array("ris"=>"N"); //utente inesistente
                echo json_encode($array);
            }
        }
    }
    $connessione -> close();
?>
