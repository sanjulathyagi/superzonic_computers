<?php
ob_start();
include '../config.php';
include 'header.php';
include '../function.php';

$order_id = $_GET['order_id'];
// Fetch order details from the database
$db = dbConn();
$sql = "SELECT o.*, c.FirstName, c.LastName 
        FROM orders o 
        LEFT JOIN customers c ON c.CustomerId = o.customer_id 
        WHERE o.id = '$order_id'";
$result = $db->query($sql);
$order = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle the cancellation process here
    $cancel_reason = $_POST['cancel_reason'];
    
    // Update order status in the database
    $sql = "UPDATE orders SET order_status='4', cancel_reason='$cancel_reason' WHERE id='$order_id'";
    if ($db->query($sql)) {
        header('Location: account.php');
        exit();
}
}


?>
<style>
    .order-number {
    font-size: 16px; 
    font-weight: bold; 
    font-family: Arial, sans-serif;
 
}
</style>
<main id="main">
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Cancel Order</h2>
            </div>
        </div>
    </section>

    <section id="cancel-order" class="contact">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Cancel Your Order</h2>
                <p>Please confirm the cancellation of your order.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="border card border-warning ">
                        <div class="card-body">
                        <p>Order Number: <span class="order-number"><?= $order['order_number']; ?></span></p>
                            <p><strong>Order Date:</strong> <?= $order['order_date'] ?></p>
                            <p><strong>Customer Name:</strong> <?= $order['FirstName'] . ' ' . $order['LastName'] ?></p>
                            
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="cancel_reason">Reason for Cancellation</label>
                                    <textarea name="cancel_reason" id="cancel_reason" class="form-control" rows="4" required></textarea>
                                </div>
                                
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-danger">Confirm Cancellation</button>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<?php
 include 'footer.php';
 ob_end_flush();
  ?>
