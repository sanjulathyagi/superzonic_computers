<?php

//Create Database Conection-------------------
function dbConn() {
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "superzonic";

    $conn = new mysqli($server, $username, $password, $db);

    if ($conn->connect_error) {
        die("Database Error : " . $conn->connect_error);
    } else {
        return $conn;
    }
}

//End Database Conection-----------------------
//Data Clean------------------------------------------
function dataClean($data = null) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

//End Data Clean
?>