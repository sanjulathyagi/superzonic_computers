<?php

include '../../function.php';


$db =dbConn();
$sql = "SELECT COUNT(*) as 'NOOFOITEMS' FROM items";
$result = $db->query($sql);
$row = $result->fetch_assoc();

echo $row['NOOFOITEMS'] ;
?>