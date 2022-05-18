<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrarre il json
    $data = json_decode(file_get_contents("php://input"));

    $user = $data -> username;
    $email = $data -> email;
    $pass = $data -> password;
    $new_pass = $data -> new_pass;
    $cmd = $data -> cmd;

    if(!empty($user) and !empty($email) and !empty($pass)){
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
            if(strcmp($cmd, "ch_pass") != 0){
                $sql = "SELECT *
                        FROM utente
                        WHERE username = '$user'
                        AND email = '$email' 
                        AND password = '$pass'";
                $result = $conn -> query($sql);
                if($result -> num_rows > 0){
                    $array = array("ris"=>"Y");
                }else{
                    $array = array("ris"=>"N");
                }
                echo json_encode($array);
            }elseif(strcmp($cmd, "ch_pass") == 0){
                if(strlen($new_pass)>=8){
                    $sql = "UPDATE utente
                            SET password = '$new_pass'
                            WHERE id = (SELECT id
                                        FROM utente
                                        WHERE username = '$user')";
                    if($conn -> query($sql)){
                        $array = array("ris"=>"Y");
                    }else{
                        $array = array("ris"=>"N");
                    }
                }else{
                    $array = array("ris"=>"Lunghezza");
                }
                echo json_encode($array);
            }
        }
    }else{
        $array=array("ris"=>"Campi mancanti");
        echo json_encode($array);
    }
?>