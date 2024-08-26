<?php
include '../init.php';
include '../../mail.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $quotation_id = $_GET['quotation_id'];
    $supplier_id = $_GET['supplier_id'];
    $order_date = date('Y-m-d');

    // Get the total amount from the quotation
    $db = dbConn();
    $sql = "SELECT total_amount FROM quotations WHERE id = '$quotation_id'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    $total_amount = $row['total_amount'];

    // Insert the purchase order
    $sql = "INSERT INTO purchase_order (quotation_id, supplier_id, order_date, total_amount) 
            VALUES ('$quotation_id', '$supplier_id', '$order_date', '$total_amount')";
    $db->query($sql);

    // Get the last inserted purchase order ID
    $purchase_order_id = $db->insert_id;

     // Get the items related to the quotation
     $sql = "SELECT item_id, quantity, unit_price 
     FROM quotation_items 
     WHERE quotation_id = '$quotation_id'";
    $result = $db->query($sql);

      // Insert each item into the purchase_order_items table
      while ($item = $result->fetch_assoc()) {
        $item_id = $item['item_id'];
        $quantity = $item['quantity'];
        $unit_price = $item['unit_price'];

        $sql = "INSERT INTO purchase_order_items (purchase_order_id, item_id, quantity, unit_price) 
                VALUES ('$purchase_order_id', '$item_id', '$quantity', '$unit_price')";
        $db->query($sql);
    }


    //supplier_details
    $sql = "SELECT s.SupplierName, s.Email
    FROM supplier s
    WHERE id = '$supplier_id'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();


    $SupplierName = $row['SupplierName'];
    $Email = $row['Email'];
  
    // Prepare email details
    $$SupplierName = $supplier['SupplierName'];
    $email = $supplier['Email'];
    $subject = "Purchase Order Confirmation";
    $message = "<h1>Purchase Order Confirmation</h1>";
    $message .= "<p>Dear $SupplierName,</p>";
    $message .= "<p>We are pleased to inform you that your quotation has been approved. A purchase order has been generated.</p>";
    $message .= "<p><b>Order Date:</b> $order_date</p>";
    $message .= "<p><b>Total Amount:</b> $total_amount</p>";
    $message .= "<p>Please review the purchase order and proceed accordingly.</p>";
    $message .= "<p>Best Regards,<br>SuperZonic Computers</p>";

    // Send email to the supplier
    sendEmail($Email, $SupplierName, $subject, $message);

    // Redirect to a success page or back to the list of quotations
    header('Location: success_purchase_order.php?purchase_order_id=' . $purchase_order_id);
    exit();
}
?>