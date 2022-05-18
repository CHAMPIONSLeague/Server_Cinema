<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrazione json
    $data = json_decode(file_get_contents("php://input"));
	$user = $data -> username;
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cinema";
    
    // Creazione connessione
    $connessione = new mysqli($servername, $username, $password, $dbname);

    if($connessione->connect_error){
        die("Connection failed: " . $connessione->connect_error);
        $array = array("ris" => "Connessione Persa");
    }else{
        $sql="SELECT * FROM prenotazione WHERE id=(SELECT id
                                                   FROM utente
                                                   WHERE username = '$user')";
        $result = $connessione -> query($sql);
        
        //caricamento dei dati sull'array
        while($row = $result -> fetch_assoc()){
            $array = array("codice_prenotazione"=>$row["codice_prenotazione"],
                           "id"=>$row["id"],
                           "codice_spettacolo"=>$row["codice_spettacolo"],
                           "data_ora"=>$row["data_ora"],
                           );
            echo json_encode($array);
        }
    }
?>
