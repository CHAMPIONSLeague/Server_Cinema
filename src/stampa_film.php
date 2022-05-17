<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrazione json
    $data = json_decode(file_get_contents("php://input"));
    
    $servername = "localhost";
    $username = "clowncinema";
    $password = "85GuHQA67pzx";
    $dbname = "my_clowncinema";
    
    // Creazione connessione
    $connessione = new mysqli($servername, $username, $password, $dbname);

    if($connessione->connect_error){
        die("Connection failed: " . $connessione->connect_error);
        $array = array("ris" => "Connessione Persa");
    }else{
        $sql="SELECT * FROM film";
        $result = $connessione -> query($sql);
        
        //caricamento dei dati sull'array
        while($row = $result -> fetch_assoc()){
            $array = array("codice_film"=>$row["codice_film"],
                           "nome_film"=>$row["nome"],
                           "durata"=>$row["durata"],
                           "descrizione"=>$row["descrizione"]);
            echo json_encode($array);
        }
    }
    $connessione -> close();
?>