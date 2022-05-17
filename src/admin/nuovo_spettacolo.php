<?php

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrarre il json
    $data=json_decode(file_get_contents("php://input"));

    $cod_sa = $data -> codice_sala; //codice_sala
    $cod_fi = $data -> codice_film; //codice_film
    $datehh = $data -> data_ora; //datehh
    $cmd = $data -> cmd;

    if(!empty($cod_sa) and !empty($cod_fi) and !empty($datehh)){
        $servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "cinema";

        $conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            $array = array("ris" => "Connessione Persa");
		}else{
            if(strcmp($cmd,"new_spet") != 0){
                $sql = "SELECT *
                        FROM sala
                        WHERE codice_sala = '$cod_sa'";
                $result = $conn -> query($sql);
                if($result -> num_rows > 0){
                    $sql = "SELECT *
                            FROM spettacolo
                            WHERE codice_sala = '$cod_sa' AND codice_film = '$cod_fi AND data_ora = '$datehh''";
                    $result = $conn -> query($sql);
                    if($result -> num_rows > 0){
                        $array = array("ris"=>"N");
                    }else{
                        $array = array("ris"=>"Y");
                    }
                    echo json_encode($array);
                }else{
                    $array = array("ris"=>"N");
                    echo json_encode($array);
                }
            }elseif(strcmp($cmd,"new_spet") == 0) {
                $sql = "INSERT INTO spettacolo(codice_sala,codice_film,data_ora) VALUES('$cod_sa','$cod_fi','$datehh')";
                if($conn->query($sql)){
                    $array = array("ris"=>"Y");
                }else{
                    $array = array("ris"=>"N");
                }
                echo json_encode($array);
            }
        }
    }
?>