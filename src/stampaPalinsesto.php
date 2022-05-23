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
        $sql = "SELECT PAL.codice_spettacolo, F.nome, SP.codice_sala, SP.data_ora, SP.p_occupati
        FROM spettacolo SP, palinsesto PAL, film F
        WHERE SP.codice_spettacolo = PAL.codice_spettacolo
        AND F.codice_film = SP.codice_film;";
        $result = $connessione -> query($sql);
        
        //caricamento dei dati sull'array
        while($row = $result -> fetch_assoc()){
            $array = array("Spettacolo"=>$row["codice_spettacolo"],
                           "Sala"=>$row["codice_sala"],
                           "Film"=>$row["nome"],
                           "Data/Ora"=>$row["data_ora"],
                           "Posti occupati"=>$row["p_occupati"]);
            echo json_encode($array);
        }
    }
    $connessione -> close();
?>