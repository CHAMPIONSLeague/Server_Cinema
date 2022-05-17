<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrarre il json
    $data = json_decode(file_get_contents("php://input"));

    $nome_film = $data -> nome;
    $durata = $data -> durata;
    $descrizione = $data -> descrizione;

    if(!empty($nome_film) && !empty($durata) && !empty($descrizione)){
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
            $sql="SELECT * FROM film where nome='$nome_film'";
            $result=$conn->query($sql);
            if ($result->num_rows>0){
                $array=array("ris"=>"Esiste gia' una film con questo nome");
                echo json_encode($array);
            }else{
                $sql="INSERT INTO film (nome, durata, descrizione) VALUES ('$nome_film', '$durata', '$descrizione')";
                
                if($conn->query($sql)===true){
                    $array=array("ris"=>"Y");
                }else{
                    $array=array("ris"=>"N"); 
                }
            }
            echo json_encode($array);
        }

    }
?>