<?php
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Controll-Allow-Methods: POST");

    //estrazione json
    $data = json_decode(file_get_contents("php://input"));

    $servername = "localhost";
    $username = "clowncinema";
    $password = "85GuHQA67pzx";
    $dbname = "my_clowncinema";

    $email = $_GET["email"];
    $token = $_GET["token"];

    // Creazione connessione
    $connessione = new mysqli($servername, $username, $password, $dbname);

    if ($connessione->connect_error) {
        die("Connection failed: " . $connessione->connect_error);
        $array = array("ris" => "Connessione Persa");
    } else {
        if ($token =="Y" && !empty($email)) {
            $sql = "DELETE FROM utente WHERE email = '$email'";

            if ($connessione->query($sql)) {
                $oggetto = "Account eliminato";
                $txt = "Il tuo account è stato eliminato dai nostri DataBase!";
                $headers = "From: clowncinema@altervista.org";

                mail($email, $oggetto, $txt, $headers);

                $array = array("ris" => "Account eliminato");
                echo json_encode($array);
            } else {
                $array = array("ris" => "Email errata"); //utente inesistente
                echo json_encode($array);
            }
        } else {
            $array = array("ris" => "Campi vuoti");
            echo json_encode($array);
        }
    }
    $connessione->close();
?>