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
        //TODO: sottrarre ai posti totali della sala i posti occupati e returnare quello con la chiave "ris"
        $sql="SELECT (SA.dim_sala-SP.p_occupati) AS posti_liberi FROM sala SA, spettacolo SP WHERE SA.codice_sala=SP.codice_sala";

        $result = $connessione -> query($sql);
        
        //caricamento dei dati sull'array
        while($row = $result -> fetch_assoc()){
            $array = array("posti_liberi"=>$row["posti_liberi"]);
            echo json_encode($array);
        }
    }
    $connessione -> close();
?>