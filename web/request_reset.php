<?php
include '../function.php';
date_default_timezone_set('Asia/Colombo');
include '../mail.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main class="col-lg-10">
        <div>
        <?php
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
        extract($_POST);

        $reset_token = bin2hex(random_bytes(16));
        $expiration_time = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $db=dbConn();

        $sql="UPDATE users u INNER JOIN customers c ON c.UserId=u.UserId SET u.reset_token='$reset_token', u.reset_expiration='$expiration_time'
                   WHERE c.Email='$Email'";


        $db->query($sql);

        $sql ="SELECT * FROM users u INNER JOIN customers c ON c.UserId=u.UserId WHERE c.Email='$Email'";

        $result=$db->query($sql);

        $row=$result->fetch_assoc();

        $FirstName=$row['FirstName'];

        if ($result->num_rows>0){
                $msg="<h1>RESET Password</h1>";

                
    
                $msg.="<p>Now you can reset your password</p>";

    
                $msg.="<a href='http://localhost/SIRMS/web/reset_password.php?token=$reset_token'>Click here to reset your account</a>";
    
                sendEmail($Email,$FirstName,"Reset password",$msg);

        }

        

        

        
     }



?>
        </div>
    </main>

    
</body>
</html>