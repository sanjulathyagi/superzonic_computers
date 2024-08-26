<?php

include '../config.php';
include 'header.php';
include '../function.php';
extract($_GET); 

$order_id=$_GET['order_id'];
$db = dbConn();
//order details
 $sql = "SELECT o.*,c.*
 FROM orders o
 LEFT JOIN customers c ON c.CustomerId= o.customer_id
 WHERE o.id='$order_id'";
$result = $db->query($sql);
$order = $result->fetch_assoc();

$customer_id = $order['customer_id'];


//order_items
 $sql = "SELECT oi.*,i.* 
 FROM order_items oi 
 LEFT JOIN items i ON i.id=oi.item_id
 WHERE oi.order_id='$order_id'";
$result = $db->query($sql);
$order_items = [];
while ($row = $result->fetch_assoc()) {
    // Fetch item name
    $item_id = $row['item_id'];
    $sql_item = "SELECT item_name FROM items WHERE id='$item_id'";
    $item_result = $db->query($sql_item);
    $item = $item_result->fetch_assoc();
    
    $row['item_name'] = $item['item_name'];
    $order_items[] = $row;
}



$delivery_name = '';
$delivery_address = '';
$delivery_district = '';
$delivery_email = '';
$delivery_phone = '';

$billing_name = '';
$billing_address = '';
$billing_district = '';
$billing_email = '';
$billing_phone = '';
$delivery_method='';
$delivery_cost=0;


$discount_amount = $delivery_fee = 0;
// Calculate totals
$subtotal = 0;
foreach ($order_items as $item) {
    $subtotal += $item['unit_price'] * $item['qty'];
}
$discount = $order['discount'];
$delivery_fee = $order['delivery_cost'];
$total_amount = ($subtotal - $discount) + $delivery_fee;

?>
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }


    .total {
        border-top: 2px solid #000;
        margin-top: 10px;
    }
</style>

</script>
<main id="main">
    <section class="breadcrumbs">

    </section>

    <main id="main">
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <img src="<?= WEB_URL ?>assets/img/logo design.jpeg" alt="" class="img-fluid" width="100"></a>
                    <h2 class="mb-4 text-warning text-center">Order Summary</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="border card border-warning ">
                            <div class="card-body">
                                <h4 class="mb-4 text-center">Thank you for your Order!</h4>
                                <h5 class="mb-4 text-center">Your order has been successfully placed</h5>


                            </div>
                        </div>
                    </div>

                </div>

                <h1>Order Summary</h1>
                <table class="table table-stripped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th colspan="2"  style="color:white; background-color:black">Order Details</th>
                        </tr>
                    </thead>

                    <tr>
                        <td><strong>Order Number:</strong></td>
                        <td><?= $order['order_number']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Order Date:</strong></td>
                        <td><?= $order['order_date']; ?></td>
                    </tr>
                    <tr>
                        <th colspan="2" style="color:white; background-color:black">Billing Information</th>
                    </tr>
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td><?= $order['FirstName'] . ' ' . $order['LastName']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Address:</strong></td>
                        <td><?= $order['billing_address']; ?></td>
                    </tr>
                    
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><?= $order['billing_email']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Phone:</strong></td>
                        <td><?= $order['billing_phone']; ?></td>
                    </tr>

                    <tr>
                        <th colspan="2"  style="color:white; background-color:black">Delivery Information</th>
                    </tr>
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td><?= $order['delivery_name']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Address:</strong></td>
                        <td><?= $order['delivery_address']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>District:</strong></td>
                        <td><?= $order['delivery_district']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><?= $order['delivery_email']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Phone:</strong></td>
                        <td><?= $order['delivery_phone']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Delivery Method:</strong></td>
                        <td><?= ucfirst($order['delivery_method']); ?></td>
                    </tr>

                    <tr>
                        <th colspan="2"  style="color:white; background-color:black">Order Items</th>
                    </tr>
                    <tr class="thead-light">
                        <th>Item</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                    </tr>
                    <?php foreach ($order_items as $item): ?>
                    <tr>
                        <td><?= $item['item_name']; ?></td>
                        <td><?= number_format($item['unit_price'], 2); ?></td>
                        <td><?= $item['qty']; ?></td>
                        <td><?= number_format($item['unit_price'] * $item['qty'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>

                    <tr class="total">
                        <td><strong>Subtotal:</strong></td>
                        <td><?= number_format($subtotal, 2); ?></td>
                    </tr>
                    <tr class="total">
                        <td><strong>Discount:</strong></td>
                        <td><?= number_format($discount, 2); ?></td>
                    </tr>
                    <!-- <tr class="total">
                        <td><strong>Delivery Fee:</strong></td>
                        <td><?= number_format($delivery_fee, 2); ?></td>
                    </tr> -->
                    <tr class="total">
                        <td><strong>Total Amount:</strong></td>
                        <td><?= number_format($total_amount, 2); ?></td>
                    </tr>
                </table>
                <br>
                <div class="footer">
                    <p>Thank you for your order!</p>
                    <p>If you have any questions, please contact us at <a
                            href="mailto:support@yourcompany.com">support@yourcompany.com</a> or <a
                            href="http://localhost/SIRMS/web/index.php">Visit our website</a></p>
                </div>

                <div class="action-buttons" style="text-align: center; margin-top: 20px;">
                    <a href="<?=WEB_URL ?>item.php" class="btn btn-success">Continue Shopping</a>
                    <a href="cancel_order.php?order_id=<?= htmlspecialchars($order_id) ?>" class="btn btn-danger">Cancel
                        Order</a>
                </div>
            </div>
        </section>
    </main>
    </body>



    <?php
include 'footer.php';
?>