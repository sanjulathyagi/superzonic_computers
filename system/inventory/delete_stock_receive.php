<?php
session_start();
include_once '../init.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE it.* FROM items_stock it WHERE it.id=$id";
    $db->query($sql); 
    header("Location:stock_receive.php");
}
