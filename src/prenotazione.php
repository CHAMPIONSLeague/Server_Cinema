<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrazione json
    $data = json_decode(file_get_contents("php://input"));
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cinema";

    $cod_sp = $data -> cod_sp;

    // Creazione connessione
    $connessione = new mysqli($servername, $username, $password, $dbname);

    if($connessione->connect_error){
        die("Connection failed: " . $connessione->connect_error);
        $array = array("ris" => "Connessione Persa");
    }else{
        if(!empty($cod_sp)){
            $sql = "SELECT SP.p_occupati, SA.dim_sala
                    FROM spettacolo SP, sala SA 
                    WHERE SP.codice_spettacolo = '$cod_sp' AND SA.codice_sala = SP.codice_sala";
            $result = $connessione -> query($sql);
            
            $row = $result -> fetch_assoc();

            if($result -> num_rows > 0){
                if($row["p_occupati"]<$row["dim_sala"]){
                    $array = array("ris" => "PE");
                    //update dei posti nello spettacolo nel caso ci siano posti disponibili
                    $sql = "UPDATE spettacolo
                            SET p_occupati = p_occupati+1";
                    $connessione -> query($sql);
                    
                    //SQL ROTTO --> DA AGGIUSTARE
                    $sql = "INSERT INTO prenotazione(username,codice_film,data_ora) VALUES "
                }else if($row["p_occupati"]=$row["dim_sala"]){
                    $array = array("ris" => "PN");
                }
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