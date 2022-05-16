<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrazione json
    $data = json_decode(file_get_contents("php://input"));
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cinema";

    $nome_film = $data -> nome_film;

    // Creazione connessione
    $connessione = new mysqli($servername, $username, $password, $dbname);

    if($connessione->connect_error){
        die("Connection failed: " . $connessione->connect_error);
        $array = array("ris" => "Connessione Persa");
    }else{
        if(!empty($nome_film)){
            $sql = "SELECT codice_spettacolo FROM film WHERE nome_film = '$nome_film'";
            $result = $connessione -> query($sql);
            $row = $result -> fetch_assoc();
            $cod_sp = $row["codice_spettacolo"];

            $sql = "SELECT SP.p_occupati, SA.dim_sala
                    FROM spettacolo SP, sala SA, film F
                    WHERE SP.codice_spettacolo = $cod_sp
                    AND SA.codice_sala = SP.codice_sala";
            $result = $connessione -> query($sql);
            $row = $result -> fetch_assoc();

            if($result -> num_rows > 0){
                //controllo dei posti
                if($row["p_occupati"]<$row["dim_sala"]){
                    //estraggo il codice del film per l'update
                    $cod_film = $row["codice_film"];

                    //update dei posti nello spettacolo nel caso ci siano posti disponibili
                    $sql = "UPDATE spettacolo
                            SET p_occupati = p_occupati+1
                            WHERE codice_spettacolo = '$cod_sp'";
                    $result = $connessione -> query($sql);

                    //inserisce la prenotazione all'interno della tabella
                    $sql = "INSERT INTO prenotazione(username,codice_film,data_ora)
                            VALUES('$user','$cod_film',CURRENT_TIMESTAMP)";
                    $result = $connessione -> query($sql);
                    $array = array("ris" => "Y");
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