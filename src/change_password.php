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
    $cmd = $data -> cmd;
    
    // Creazione connessione
    $connessione = new mysqli($servername, $username, $password, $dbname);

    if($connessione->connect_error){
        die("Connection failed: " . $connessione->connect_error);
        $array = array("ris" => "Connessione Persa");
    }else{
        if(!empty($user) && !empty($cmd)){
            $sql = "SELECT * FROM utente WHERE username = '$user'";
            $result = $connessione -> query($sql);

            if($result -> num_rows > 0){
                //utente esistente
                $row = $result -> fetch_assoc();
                $email = $row["email"];

                //manda l'email di verifica
                //apri l'email e vai sul form
                //fai il form per le password
                //prendi i dati dal form
                //cambi i dati sul db 
                //di al client che hai aggiornato la password

            }else{
                $array = array("ris"=>"N");
                echo json_encode($array);
            }
            //todo: fare la connessione e l'email 
        }
        
    }
    $connessione -> close();
?>
