<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrarre il json
    $data=json_decode(file_get_contents("php://input"));

    $nome_film=$data -> nome;
    $durata=$data -> durata;
    $descrizione=$data -> descrizione;

    if(!empty($username) && !empty($email) && !empty($password)){
        $servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "cinema";

        $conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            $array = array("ris" => "Connessione Persa");
            $sql="SELECT * FROM film where nome='$nome_film'";
		}else{
            $result=$conn->query($sql);
            if ($result->num_rows>0){
                $array=array("ris"=>"non esiste già una film con questo nome");
                echo json_encode($array);
            }else{
                $sql="UPDATE film SET nome = '$nome_film', descrizione = '$descrizione', durata = '$durata' WHERE codice_film = (SELECT codice_film FROM film where nome='$nome_film')";
                
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