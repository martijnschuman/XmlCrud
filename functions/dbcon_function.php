<?php

function dbConn(){
    $servername = "localhost";
    $dBUsername = "root";
    $dBPassword = "";
    $dBName = "playMusic";
    $conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);
    if(!$conn){
        die("Verbinding met database mislukt: ".mysqli_connect_error());
    }
    return $conn;
}

//Als je de functie meerdere keren moet gebruiken
function executeQueryAsArray($query, $conn) {
    $result = mysqli_query($conn, $query);
    if ($result) {
        while($row = mysqli_fetch_assoc($result)) {       
            $output[] = $row;
        }
    } else {
        var_dump($result);
    }

    return $output;
}

//Als je de functie één keer moet gebruiken
function executeQueryAsRow($query, $conn) {
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
    } else {
        var_dump($result);
    }

    return $row;
}