<?php
include_once '../init.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE s.* FROM supplier s WHERE s.id = '$id'";
    $db->query($sql); 
    header("Location:manage.php");
}