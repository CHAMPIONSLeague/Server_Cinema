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
    $cmd = $data -> cmd;

    // Creazione connessione
    $connessione = new mysqli($servername, $username, $password, $dbname);

    if($connessione->connect_error){
        die("Connection failed: " . $connessione->connect_error);
        $array = array("ris" => "Connessione Persa");
    }else{
        if(!empty($user) and !empty($cod_sp)){
            if(strcmp($cmd, "del_pr") != 0){
                //vado a vedere se sono presenti prenotazioni attive
                $sql = "SELECT *
                        FROM prenotazione
                        WHERE id = (SELECT id
                                    FROM utente
                                    WHERE username = '$user') AND codice_spettacolo = '$cod_sp' AND data_ora < (SELECT data_ora
                                                                                                                FROM spettacolo
                                                                                                                WHERE codice_spettacolo = '$cod_sp')";
                $result = $connessione -> query($sql);
                if($result -> num_rows > 0){
                    $array = array("ris"=>"Y");
                }else{
                    $array = array("ris"=>"N");
                }
                echo json_encode($array);
            }elseif(strcmp($cmd, "del_pr") == 0){
                //cancello la prenotazione selezionata dall'utente
                $sql = "DELETE FROM prenotazione
                        WHERE codice_spettacolo = '$cod_sp' AND id = (SELECT id
                                                                      FROM utente
                                                                      WHERE username = '$user')";
                if($connessione -> query($sql)){
                    //aggiornamento dei posti occupati dello spettacolo interessato
                    $sql = "UPDATE spettacolo
                            SET p_occupati = p_occupati-1
                            WHERE codice_spettacolo = '$cod_sp'";
                    if($connessione->query($sql)){
                        $array = array("ris"=>"Y");
                    }else{
                        $array = array("ris"=>"N");
                    }
                    echo json_encode($array);
                }else{
                    $array = array("ris"=>"N");
                    echo json_encode($array);
                }
            }
        }
    }
?>