<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrarre il json
    $data = json_decode(file_get_contents("php://input"));

    $email = $data -> email;
    $pass = $data -> password;
    $new_user = $data -> new_user; //associo alla variabile $new_email l'email inviata dal client tramite key json "new_email";
    $funx = $data -> funx;

    if(!empty($email) && !empty($pass)){
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
            if(strcmp($funx, "ch_user") != 0){
                $sql="SELECT * 
                      FROM utente
                      WHERE email = '$email' AND password = '$pass'";
                $result=$conn->query($sql);
                if ($result->num_rows>0){
                    //se la risposta è Y allora ricevo dal client la nuova mail;
                    $array=array("ris"=>"Y");
                    echo json_encode($array);
                }
            }elseif(strcmp($funx, "ch_user") == 0){
                //aggiornamento dell'user nella tabella
                $sql = "UPDATE utente
                        SET username = '$new_user'
                        WHERE email = '$email' AND password = '$pass'";
                if($conn->query($sql)){
                    $array=array("ris"=>"Username aggiornato");
                    echo json_encode($array);
                }else{
                    $array=array("ris"=>"Questo username e' gia' registrato");
                    echo json_encode($array);
                }
            }
        }
    }else{
        $array=array("ris"=>"Campi mancanti");
        echo json_encode($array);
    }
?>