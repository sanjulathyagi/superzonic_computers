<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Invoice";
$breadcrumb_item_active = "Payment";
$alert=false;

// Fetch invoice details
$id = $_GET['id'];
$db = dbConn();
$sql = "SELECT iv.*, s.SupplierName
        FROM invoices iv
        INNER JOIN supplier s ON s.id=iv.supplier_id
        WHERE iv.id='$id'";
$result = $db->query($sql);
$invoice = $result->fetch_assoc();


//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);


$message = array();
if (empty($amount)) {
    $message['amount'] = "The amount should not be blank...!";
}
if (empty($payment_date)) {
    $message['payment_date'] = "The payment_date should not be blank...!";
}
}
?>
<main id="main">
    <section class="breadcrumbs">
        <div class="container">
            <!-- Breadcrumbs and Invoice Details -->
        </div>
    </section>
    
    <!-- Invoice Details -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Invoice Details</h3>
                </div>
                <div class="card-body">
                    <p>Invoice Number: <?= htmlspecialchars($invoice['invoice_number']) ?></p>
                    <p>Supplier: <?= htmlspecialchars($invoice['SupplierName']) ?></p>
                    <p>Total Amount: <?= htmlspecialchars($invoice['total_amount']) ?></p>
                    <!-- Add other invoice details as needed -->
                    
                    <!-- Payment Upload Form -->
                    <h4>Record Payment</h4>
                    <form action="<?=SYS_URL ?>payments/process_payment.php" method="post" enctype="multipart/form-data" novalidate>
                        <input type="hidden" name="invoice_id" value="<?= htmlspecialchars($invoice['id']) ?>">
                        
                        <div class="form-group">
                            <label for="amount">Amount Paid</label>
                            <input type="text" class="form-control" id="amount" name="amount" required>
                            <span class="text-danger"><?= @$message['amount'] ?></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="payment_date">Payment Date</label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                            <span class="text-danger"><?= @$message['payment_date'] ?></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="payment_slip">Payment Slip</label>
                            <input type="file" class="form-control-file" id="payment_slip" name="payment_slip" required>
                            
                        </div>
                        
                        <button type="submit" class="btn btn-warning btn-sm">Submit Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
$content= ob_get_clean();
include '../layouts.php';
?>