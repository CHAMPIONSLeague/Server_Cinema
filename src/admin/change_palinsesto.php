<?php

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrarre il json
    $data=json_decode(file_get_contents("php://input"));

    $cod_sa = $data -> codice_sala; //codice_sala
    $cod_fi = $data -> codice_film; //codice_film
    $datehh = $data -> data_ora; //datehh

    $servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "cinema";

    $conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        $array = array("ris" => "Connessione Persa");
        echo json_encode($array);
	}else{
        if(!empty($cod_sa) and !empty($cod_fi) and !empty($datehh)){
            $sql = "SELECT *
                    FROM palinsesto";
            $result = $conn -> query($sql);
            if($result -> num_rows < 6){
                $sql = "SELECT *
                        FROM palinsesto
                        WHERE codice_spettacolo = (SELECT codice_spettacolo
                                                FROM spettacolo
                                                WHERE codice_sala = '$cod_sa'
                                                AND codice_film = '$cod_fi'
                                                AND data_ora = '$datehh')";
                $result = $conn -> query($sql);
                if($result -> num_rows < 3){
                    $sql = "INSERT INTO palinsesto(codice_spettacolo)
                            VALUES(SELECT codice_spettacolo
                                FROM spettacolo 
                                WHERE codice_sala = '$cod_sa'
                                AND codice_film = '$cod_fi'
                                AND data_ora = '$datehh')";
                    if($conn -> query($sql)){
                        $array = array("ris"=>"Y");
                    }else{
                        $array = array("ris"=>"NI");
                    }
                    echo json_encode($array);
                }else{
                    $array = array("ris"=>"Limit"); //se viene superato il limite di 3 proiezioni
                    echo json_encode($array);
                }
            }else{
                $array = array("ris"=>"NP"); //se viene superato il limite di 6 proiezioni
                echo json_encode($array);
            }
        }else{
            $array = array("ris"=>"Campi mancanti");
            echo json_encode($array);
        }
    }
?>