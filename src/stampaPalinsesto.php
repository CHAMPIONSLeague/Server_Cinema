<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrazione json
    $data = json_decode(file_get_contents("php://input"));
    
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
        $sql = "SELECT * FROM spettacolo";
        $result = $connessione -> query($sql);
        
        //caricamento dei dati sull'array
        while($row = $result -> fetch_assoc()){
            $array = array("cod_sp"=>$row["codice_spettacolo"],
                           "cod_sa"=>$row["codice_sala"],
                           "cod_fi"=>$row["codice_film"],
                           "data_ora"=>$row["data_ora"],
                           "p_occupati"=>$row["p_occupati"]);
            echo json_encode($array);
        }
    }
    $connessione -> close();
?>