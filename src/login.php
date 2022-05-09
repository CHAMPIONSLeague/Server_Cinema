<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrazione json
    $data = json_decode(file_get_contents("php://input"));
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cinema";

    $user = $data -> username;
    $pass = $data -> password;

    // Creazione connessione
    $connessione = new mysqli($servername, $username, $password, $dbname);

    if($connessione->connect_error){
        die("Connection failed: " . $connessione->connect_error);
        $array = array("ris" => "Connessione Persa");
    }else{
        if(!empty($user) && !empty($pass)){
            $sql = "SELECT email FROM utente WHERE username = '$user' AND password = '$pass'";
            $result = $connessione -> query($sql);
    
            if($result -> num_rows > 0){
                $array = array("ris" => "Y");
            }else{ 
                $array = array("ris" => "N");
            }
        }else{
            $array = array("ris" => "Campi mancanti");
        }
        echo json_encode($array);
    }
    $connessione -> close();
?>