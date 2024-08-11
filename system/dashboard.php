<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user_type=$_SESSION['DESIGNATION'];
$dashboard="dashboard_$user_type.php";

include_once($dashboard);

?>