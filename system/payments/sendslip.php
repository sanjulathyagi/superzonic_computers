<?php
ob_start();
date_default_timezone_set('Asia/Colombo');

include '../init.php';
include '../../mail.php';

?>
<?php
//      if ($_SERVER["REQUEST_METHOD"] == "GET") {
//         extract($_GET);
//         $db=dbConn();
//         $sql= "SELECT 
//         FROM payment p

//         WHERE p.id = '$payment_id' ";

//         $result = $db->query($sql);
//         $row = $result->fetch_assoc();

//         $Email=$row['Email'];
//         $supplier_id=$row['supplier_id'];
//         $SupplierName=$row['SupplierName'];
      


//         //update the price request with reset token
//         $db=dbConn();
//         $sql="UPDATE orders o SET order_status=paid'WHERE ";
//         $db->query($sql);  
        
        $msg = "<h1>SUCCESS</h1>";
        $msg .= "<h2>Congratulations</h2>";
        $msg .= "<p>Your account has been successfully created</p>";
        $msg .= "Click here to verify your account</a>";
        $pdf_file = __DIR__ . '/../../docs/payment_receipt.pdf';
        
        $msg.="<p><b>SuperZonic Computers</b></p>";
        $msg.="<p><b> NO. 50/1 <br>
                          NIDHAS MAWATHA<br>
                          KEGALLE<b></p>";
        $msg.=" <p><strong>Phone:</strong> +94 771153923</p>";
        $msg.="<p><strong>Email:</strong> superzonic@gmail.com</p>";
        sendEmailWithAttachment("sanjulathyagi@gmail.com", "Sanjula", "Account Verification", $msg,$pdf_file);
        
           
        



?>