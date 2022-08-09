<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrarre il json
    $data = json_decode(file_get_contents("php://input"));

    $cod_sa = $data -> cod_sa;
    $new_sa_name = $data -> new_sa_name;
    $new_sa_dim = $data -> new_sa_dim;
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
            if(strcmp($cmd, "ch_sala") != 0){
                $sql = "SELECT * 
                        FROM sala
                        WHERE codice_sala = '$cod_sa'";
                $result = $conn->query($sql);
                if($result->num_rows>0){
                    /** 
                     * IMPORTANTE!
                     * Se trova una sala l'api deve essere richiamata dal client
                     * con i dati (nome e dim_sala) aggiornati;
                    */
                    $array = array("ris"=>"Y");
                    echo json_encode($array);
                }else{
                    $array = array("ris"=>"N");
                    echo json_encode($array);
                }
            }elseif((strcmp($cmd, "ch_sala") == 0)){
                //controllo se sono presenti spettacoli attivi assaciati alla sala interessata
                $sql = "SELECT *
                        FROM spettacolo
                        WHERE codice_sala = '$cod_sa' AND data_ora >= CURRENT_TIMESTAMP";
                $result = $conn->query($sql);
                if($result->num_rows>0){
                    $array = array("ris"=>"N");
                    echo json_encode($array);
                }else{
                    //controllo se esistono già della sale con il nome inserito dal client
                    $sql = "SELECT *
                            FROM sala
                            WHERE codice_sala = '$cod_sa' AND nome = '$new_sa_name'";
                    $result = $conn->query($sql);
                    if($result->num_rows>0){
                        $array = array("ris"=>"N");
                        echo json_encode($array);
                    }else{
                        //aggiornamento dei dati della sala interessata
                        $sql = "UPDATE sala
                                SET nome = '$new_sa_name', dim_sala = '$new_sa_dim'
                                WHERE codice_sala = $cod_sa";
                        if($conn->query($sql)){
                            $array = array("ris"=>"Y");
                            echo json_encode($array);
                        }else{
                            $array = array("ris"=>"N");
                            echo json_encode($array);
                        }
                    }
                }
            }
        }
    }else{
        $array = array("ris"=>"Campi mancanti");
        echo json_encode($array);
    }
?>