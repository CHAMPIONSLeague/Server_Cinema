<?php

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrarre il json
    $data=json_decode(file_get_contents("php://input"));

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
        $sql = "DELETE FROM palinsesto";
        if($conn -> query($sql)){
            $array = array("ris"=>"Y");
        }else{
            $array = array("ris"=>"N");
        }
        echo json_encode($array);
    }
?>