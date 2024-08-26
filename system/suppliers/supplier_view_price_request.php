<?php
ob_start();
session_start();
include_once '../init.php';


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    extract($_GET);

    $token = $_GET['token'];

    $db = dbConn();

    // Fetch the price request and items based on the token
    $sql = "SELECT pr.id as price_request_id, pr.request_date, s.SupplierName, s.Email, pi.item_id, pi.quantity, i.item_name 
            FROM price_request pr
            LEFT JOIN price_request_items pi ON pr.id = pi.price_request_id
            LEFT JOIN items i ON pi.item_id = i.id
            LEFT JOIN supplier s ON pr.supplier_id = s.id
            WHERE pr.token = '$token'";

      // Execute the query      
    $result = $db->query($sql);


    // Check if any records were returned
    if ($result->num_rows > 0) {
        $items = [];  // Initialize an empty array to store the item details

        while ($row = $result->fetch_assoc()) {
            $items[] = $row;   // Add each row (which contains item details) to the $items array



        // Extract and store supplier name, request date, and price request ID
        // These values are the same for every row, so they are only extracted once
            $supplier_name = $row['SupplierName'];
            $request_date = $row['request_date'];
            $price_request_id = $row['price_request_id'];
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = dbConn();

    // Calculate the total amount
    $total_amount = 0;
    foreach ($_POST['items'] as $item_id => $price_per_unit) {
        $quantity = $_POST['quantities'][$item_id];
        $total_price = $quantity * $price_per_unit;
        $total_amount += $total_price;
    }

    // Insert data into the quotations table with the total amount
    $quotation_date = date('Y-m-d H:i:s');
    $sql = "INSERT INTO quotations (price_request_id, supplier_id,request_date, quotation_date, total_amount, status) 
            VALUES ('$price_request_id', '$supplier_id','$request_date', '$quotation_date', '$total_amount', '0')";
    $db->query($sql);
    $quotation_id = $db->insert_id;

    // Insert data into the quotation_items table
    foreach ($_POST['items'] as $item_id => $price_per_unit) {
        $quantity = $_POST['quantities'][$item_id];
        $total_price = $quantity * $price_per_unit;

        $sql = "INSERT INTO quotation_items (quotation_id, item_id, quantity, unit_price, total_price) 
                VALUES ('$quotation_id', '$item_id', '$quantity', '$price_per_unit', '$total_price')";
        $db->query($sql);
    }

    // Redirect to a success page
    header('Location: success_quotation.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Quotation</title>
</head>
<body>
<div style="text-align: center; border-bottom: 2px solid #000; padding-bottom: 20px; margin-bottom: 20px;">
    <img src="<?= WEB_URL ?>assets/img/logo design.jpeg" alt="SuperZonic Computers" style="width: 80px; margin-bottom: 10px;">
    <h1 style="font-size: 24px; margin: 0;">SuperZonic Computers</h1>
    <p style="margin: 5px 0;">NO. 50/1, Nidhas Mawatha, Kegalle</p>
    <p style="margin: 5px 0;">Phone: +94 771153923 | Email: superzonic@gmail.com</p>
</div>

</div>
    </div>
    <h1>Quotation for Price Request</h1>
    <h2>Supplier: <?= $supplier_name ?></h2>
    <p>Request Date: <?= $request_date ?></p>

    <form action="" method="POST">
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price per Unit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) { ?>
                <tr>
                    <td><?= $item['item_name'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>
                        <input type="hidden" name="quantities[<?= $item['item_id'] ?>]" value="<?= $item['quantity'] ?>">
                        <input type="number" class="form-control" step="100.00" name="items[<?= $item['item_id'] ?>]" required>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-warning btn-sm">Submit Quotation</button>
        
    </form>
</body>
</html>
