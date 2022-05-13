<?php

use LDAP\Result;

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrarre il json
    $data=json_decode(file_get_contents("php://input"));

    $nome_sala=$data -> nome;
    $dim_sala=$data -> dim_sala;

    if(!empty($nome_sala) && !empty($dim_sala)){
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
            $sql="SELECT * FROM sala where nome='$nome_sala'";
            $result=$conn->query($sql);
            if ($result->num_rows>0){
                $array=array("ris"=>"Esiste già una sala con questo nome");
                echo json_encode($array);
            }else{
                $sql="INSERT INTO sala (nome, dim_sala) VALUES ('$nome_sala', '$dim_sala')";
                
                if($conn->query($sql)===true){
                    $array=array("ris"=>"Y");
                    echo json_encode($array);
                }else{
                    $array=array("ris"=>"N");
                    echo json_encode($array);            
                }
            }

            
        }

    }
?>