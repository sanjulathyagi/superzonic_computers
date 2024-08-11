<?php
session_start();
include_once '../init.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE faq.* FROM faq  WHERE faq.id=$id";
    $db->query($sql); 
    header("Location:manage.php");
}