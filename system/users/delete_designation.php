<?php
include_once '../init.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE d.* FROM designations d  WHERE d.Id = '$id'";
    $db->query($sql); 
    header("Location:manage.php");
}
