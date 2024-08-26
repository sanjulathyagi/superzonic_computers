<?php
ob_start();
date_default_timezone_set('Asia/Colombo');

include_once 'init.php';
include '..mail.php';
?>
<?php
extract($_GET);
extract($_POST);

$db = dbConn();
if($_SERVER['REQUEST_METHOD']=="POST" && @$action='submit'){

extract($_POST);
$msg="<h1> Purchase Request- SuperZonic Computers</h1>";
$msg .="<a href='http://localhost/SIRMS/system/purchase_send.php?token=$token'>Click Here to View purchase request</a>";
sendEmail($email,$supplier,"Purchase Request- superzonic computers",$msg);

}

?>