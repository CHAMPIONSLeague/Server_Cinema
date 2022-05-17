<?php

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrarre il json
    $data = json_decode(file_get_contents("php://input"));

    $cod_film = $data -> cod_film;
    $cmd = $data -> cmd;

    if(!empty($cod_film)){
        $servername = "localhost";
        $username = "clowncinema";
        $password = "85GuHQA67pzx";
        $dbname = "my_clowncinema";

        $conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            $array = array("ris" => "Connessione Persa");
		}else{
            if(strcmp($cmd, "del_film") != 0){
                $sql = "SELECT * 
                        FROM film
                        WHERE codice_film = '$cod_film'";
                $result = $conn->query($sql);
                if($result->num_rows>0){
                    /** 
                     * IMPORTANTE!
                     * Se trova una sala l'api deve essere richiamata dal client
                     * inviando si o no dal sout("Sei sicuro di voler eliminare questo film?");
                    */
                    $array = array("ris"=>"Y");
                    echo json_encode($array);
                }else{
                    $array = array("ris"=>"N");
                    echo json_encode($array);
                }
            }elseif((strcmp($cmd, "del_film") == 0)){
                //controllo se sono presenti spettacoli attivi assaciati al film interessato
                $sql = "SELECT *
                        FROM spettacolo
                        WHERE codice_film = '$cod_film' AND data_ora >= CURRENT_TIMESTAMP";
                $result = $conn->query($sql);
                if($result->num_rows>0){
                    $array = array("ris"=>"N");
                    echo json_encode($array);
                }else{
                    //eliminazione spettacoli
                    $sql = "DELETE FROM spettacolo
                            WHERE codice_film = '$cod_film' AND data_ora <= CURRENT_TIMESTAMP";
                    if($conn->query($sql)){
                        //eliminazione prenotazioni associate al film
                        $sql = "DELETE FROM prenotazione
                                WHERE codice_film = '$cod_film'";
                        if($conn->query($sql)){
                            //eliminazione film
                            $sql = "DELETE FROM film
                                    WHERE codice_film = '$cod_film'";        
                            if($conn->query($sql)){
                                $array = array("ris"=>"Y"); //eliminazione spettacolo/i, prenotazione/i e film effettuate
                                echo json_encode($array);
                            }else{
                                $array = array("ris"=>"N"); //eliminazione spettacolo/i e prenotazione/i effettuate (Errore: film)
                                echo json_encode($array);
                            }
                        }else{
                            $array = array("ris"=>"N"); //eliminazione spettacolo/i effettuata (Errore: prenotazione)
                            echo json_encode($array);
                        }                        
                    }else{
                        $array = array("ris"=>"N"); //errore eliminazione spettacolo/i
                        echo json_encode($array);
                    }                            
                }
            }
        }
    }else{
        $array = array("ris"=>"Campi mancanti");
        echo json_encode($array);
    }
?>