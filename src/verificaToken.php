<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: GET");

    //estrazione json
    $data = json_decode(file_get_contents("php://input"));
    
    $servername = "localhost";
    $username = "clowncinema";
    $password = "85GuHQA67pzx";
    $dbname = "my_clowncinema";

    $token = $_GET["token"];
    $email = $_GET["email"]; 
    //fai il controllo email e metti il token al posto della password
    
    // Creazione connessione
    $connessione = new mysqli($servername, $username, $password, $dbname);

    if($connessione->connect_error){
        die("Connection failed: " . $connessione->connect_error);
        $array = array("ris" => "Connessione Persa");
    }else{
        if(!empty($token) && !empty($email)){
            $sql = "UPDATE utente SET password='$token' WHERE email='$email'";
            if($connessione -> query($sql)){
                //titolo = Torna sull'applicazione e modifica la password, all'inserimento del token metti $token
                echo "<h3>Torna sull'applicazione e modifica la password, all'inserimento del token metti '$token'</h3>";
            }else{
                $array = array("ris"=>"N");
                echo json_encode($array);
            }
        }
    }
    $connessione -> close();
?>