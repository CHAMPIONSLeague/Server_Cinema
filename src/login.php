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
    $pass = $data -> password;

    // Creazione connessione
    $connessione = new mysqli($servername, $username, $password, $dbname);

    if($connessione->connect_error){
        die("Connection failed: " . $connessione->connect_error);
        $array = array("ris" => "Connessione Persa");
    }else{
        if(!empty($user) && !empty($pass)){
            $sql = "SELECT privilegi FROM utente WHERE username = '$user' AND password = '$pass'";
            $result = $connessione -> query($sql);
            
            $row = $result -> fetch_assoc();

            if($result -> num_rows > 0){
                if($row["privilegi"] == 1){
                    $array = array("ris" => "YA");
                }else if($row["privilegi"] == 0){
                    $array = array("ris" => "YU");
                }
            }else{ 
                if($row["privilegi"] == 1){
                    $array = array("ris" => "NA");
                }else if($row["privilegi"] == 0){
                    $array = array("ris" => "NU");
                }
            }
        }else{
            $array = array("ris" => "Campi mancanti");
        }
        echo json_encode($array);
    }
    $connessione -> close();
?>