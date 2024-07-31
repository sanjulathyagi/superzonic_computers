<?php
session_start();
include_once '../init.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE c.* FROM customers c WHERE c.CustomerId=$CustomerId";
    $db->query($sql); 
    header("Location:manage.php");
}
