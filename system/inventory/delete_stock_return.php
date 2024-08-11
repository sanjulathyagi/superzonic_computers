<?php
session_start();
include_once '../init.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE ri.* FROM order_return_items ri WHERE ri.id=$id";
    $db->query($sql); 
    header("Location:stock_return.php");
}
