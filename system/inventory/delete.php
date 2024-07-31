<?php
session_start();
include_once '../init.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE i.* FROM items i WHERE i.id=$id";
    $db->query($sql); 
    header("Location:items.php");
}



