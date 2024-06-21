<?php

include '../../function.php';


$db =dbConn();
$sql = "SELECT COUNT(*) as 'NOOFOAPPOINTEMNTS' FROM appointments";
$result = $db->query($sql);
$row = $result->fetch_assoc();

echo $row['NOOFOAPPOINTEMNTS'] ;
?>