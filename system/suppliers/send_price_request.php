<?php
ob_start();
date_default_timezone_set('Asia/Colombo');

include '../init.php';
include '../../mail.php';

?>
<?php
     if ($_SERVER["REQUEST_METHOD"] == "GET") {
        extract($_GET);
        $db=dbConn();
  $sql= "SELECT i.*,p.*,s.Email,s.SupplierName
        FROM price_request p
        LEFT JOIN price_request_items pi ON pi.price_request_id=p.id
        LEFT JOIN items i ON i.id=pi.item_id
        LEFT JOIN supplier s ON s.id=p.supplier_id
        WHERE p.id = '$price_request_id' ";

        $result = $db->query($sql);
        $row = $result->fetch_assoc();

        $Email=$row['Email'];
        $supplier_id=$row['supplier_id'];
        $SupplierName=$row['SupplierName'];
        $send_token= bin2hex(random_bytes(16));


        //update the price request with reset token
        $db=dbConn();
        $sql="UPDATE price_request p SET token='$send_token' WHERE p.id='$price_request_id' AND supplier_id='$supplier_id'";
        $db->query($sql);       

        $msg="<h1>Price Request</h1>";
            $msg.="<h2>Dear $SupplierName,</h2>";
            $msg.="<p>You have received a new price request.Please review it by clicking the below link</p>";
            $msg="<a href='http://localhost/SIRMS/system/suppliers/supplier_view_price_request.php?token=$send_token'>View Price Request</a>";
          

            $msg.="<p><b>SuperZonic Computers</b></p>";
            $msg.="<p><b> NO. 50/1 <br>
                              NIDHAS MAWATHA<br>
                              KEGALLE<b></p>";
            $msg.=" <p><strong>Phone:</strong> +94 771153923</p>";
            $msg.="<p><strong>Email:</strong> superzonic@gmail.com</p>";
            sendEmail($Email,$SupplierName,"Price Request",$msg);

            
            header('Location:success_email.php');
            exit();
     }



?>
