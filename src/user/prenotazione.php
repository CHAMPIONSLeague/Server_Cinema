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
    $cod_sp = $data -> cod_sp;

    // Creazione connessione
    $connessione = new mysqli($servername, $username, $password, $dbname);

    if($connessione->connect_error){
        die("Connection failed: " . $connessione->connect_error);
        $array = array("ris" => "Connessione Persa");
    }else{
        if(!empty($cod_sp)){
            $sql = "SELECT SP.p_occupati, SA.dim_sala, SP.codice_film
                    FROM spettacolo SP, sala SA
                    WHERE SP.codice_spettacolo = '$cod_sp'
                    AND SA.codice_sala = SP.codice_sala";
            $result = $connessione -> query($sql);
            $row = $result -> fetch_assoc();
            //estraggo il codice del film per l'update
            $cod_film = $row["codice_film"];

            if($result -> num_rows > 0){
                //controllo dei posti
                if($row["p_occupati"] < $row["dim_sala"]){
                    //update dei posti nello spettacolo nel caso ci siano posti disponibili
                    $sql = "UPDATE spettacolo
                            SET p_occupati = p_occupati+1
                            WHERE codice_spettacolo = '$cod_sp'";
                    $connessione -> query($sql);

                    //inserisce la prenotazione all'interno della tabella
                    $sql = "INSERT INTO prenotazione(id, codice_spettacolo, data_ora)
                            VALUES((SELECT id FROM utente WHERE username = '$user'),'$cod_sp', CURRENT_TIMESTAMP)";
                    
                    if($connessione -> query($sql)){
                        $array = array("ris" => "Y");
                    }else{
                        $array = array("ris" =>"Problema nella prenotazione");
                    }
                }else if($row["p_occupati"]=$row["dim_sala"]){
                    $array = array("ris" => "N");
                }
            }else{ 
                $array = array("ris" => "Spettacolo inesistente");
            }
        }else{
            $array = array("ris" => "Campi mancanti");
        }
        echo json_encode($array);
    }
    $connessione -> close();
?>