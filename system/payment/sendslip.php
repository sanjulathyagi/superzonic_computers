<?php
        include '../../mail.php';
        
        $msg = "<h1>SUCCESS</h1>";
        $msg .= "<h2>Congratulations</h2>";
        $msg .= "<p>Your account has been successfully created</p>";
        $msg .= "Click here to verifiy your account</a>";
        $pdf_file = __DIR__ . '/../../docs/payment_receipt.pdf';
        sendEmailWithAttachment("sanjulathyagi@gmail.com", "Sanjula", "Account Verification", $msg,$pdf_file);
        
        ?>