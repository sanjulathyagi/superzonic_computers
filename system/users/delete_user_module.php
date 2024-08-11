<?php
include_once '../init.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    extract($_GET);
    $db = dbConn();
    $sql = "DELETE u.* FROM user_modules u WHERE u.UserId = '$userid'";
    $db->query($sql); 
    header("Location:user_module.php");
}