<?php

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrarre il json
    $data = json_decode(file_get_contents("php://input"));

    $cod_sa = $data -> cod_sa;
    $cmd = $data -> cmd;

    if(!empty($cod_sa)){
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
            if(strcmp($cmd, "del_sala") != 0){
                $sql = "SELECT * 
                        FROM sala
                        WHERE codice_sala = '$cod_sa'";
                $result = $conn->query($sql);
                if($result->num_rows>0){
                    /** 
                     * IMPORTANTE!
                     * Se trova una sala l'api deve essere richiamata dal client
                     * inviando si o no dal sout("Sei sicuro di voler eliminare questa sala?");
                    */
                    $array = array("ris"=>"Y");
                    echo json_encode($array);
                }else{
                    $array = array("ris"=>"N");
                    echo json_encode($array);
                }
            }elseif((strcmp($cmd, "del_sala") == 0)){
                //controllo se sono presenti spettacoli attivi assaciati alla sala interessata
                $sql = "SELECT *
                        FROM spettacolo
                        WHERE codice_sala = '$cod_sa' AND data_ora >= CURRENT_TIMESTAMP";
                $result = $conn->query($sql);
                if($result->num_rows>0){
                    $array = array("ris"=>"N");
                    echo json_encode($array);
                }else{
                    //eliminazione delle prenotazioni
                    $sql = "DELETE FROM prenotazione
                            WHERE codice_spettacolo = (SELECT codice_spettacolo
                                                       FROM spettacolo
                                                       WHERE codice_sala = '$cod_sa' AND data_ora <= CURRENT_TIMESTAMP)";
                    if($conn->query($sql)){
                        //eliminazione spettacoli
                        $sql = "DELETE FROM spettacolo
                                WHERE codice_sala = '$cod_sa' AND data_ora <= CURRENT_TIMESTAMP";
                        if($conn->query($sql)){
                            //eliminazione sala
                            $sql = "DELETE FROM sala
                            WHERE codice_sala = '$cod_sa'";
                            if($conn->query($sql)){
                                $array = array("ris"=>"Y"); //eliminazioni prenotazione/i, spettacolo/i, sala/e
                                echo json_encode($array);
                            }else{
                                $array = array("ris"=>"N"); //errore eliminazione sala
                                echo json_encode($array);
                            }
                        }else{
                            $array = array("ris"=>"N"); //errore eliminazione spettacolo/i
                            echo json_encode($array);
                        }                 
                    }else{
                        $array = array("ris"=>"N"); //errore eliminazione prenotazioni
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
