<?php
session_start();
include_once '../init.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE sr.* FROM stock_returns sr WHERE sr.id=$id";
    $db->query($sql); 
    header("Location:stock_return.php");
}
