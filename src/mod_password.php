<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    $servername = "localhost";
    $username = "clowncinema";
    $password = "85GuHQA67pzx";
    $dbname = "my_clowncinema";

    //estrarre il json
    $data = json_decode(file_get_contents("php://input"));

    $user = $data -> username;
    $token = $data -> token; //token ricevuto dall'email legata al recupero della password
    $new_pass = $data -> new_pass;
    $cmd = $data -> cmd; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
	if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        $array = array("ris" => "Connessione Persa");
	}else{
        if(!empty($user) and !empty($token)){
            if(strcmp($cmd,"ch_pass") == 0 and !empty($new_pass)){
                //aggiornamento della password
                $sql = "UPDATE utente
                        SET password = '$new_pass'
                        WHERE username = '$user'";
                if($conn->query($sql)){
                    $array = array("ris"=>"Y"); //Y se l'update e' andato a buon fine
                }else{
                    $array = array("ris"=>"N"); //N se l'update non e' andato a buon fine
                }
                echo json_encode($array);
            }elseif(strcmp($cmd,"ch_pass") != 0){
                //selezione di controllo per verificare la presenza dell'utente
                $sql = "SELECT *
                        FROM utente
                        WHERE username = '$user' AND password = '$token'";
                $result = $conn -> query($sql);
                if($result -> num_rows > 0){
                    $array = array("ris"=>"Y"); //Y se trova l'utente
                }else{
                    $array = array("ris"=>"N"); //N se non trova l'utente
                }
                echo json_encode($array);
            }
        }
    }
?>