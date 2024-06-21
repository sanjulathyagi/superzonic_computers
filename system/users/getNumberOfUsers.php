<?php

include '../../function.php';


$db =dbConn();
$sql = "SELECT COUNT(*) as 'NOOFOUSERS' FROM users";
$result = $db->query($sql);
$row = $result->fetch_assoc();

echo $row['NOOFOUSERS'] ;
?>