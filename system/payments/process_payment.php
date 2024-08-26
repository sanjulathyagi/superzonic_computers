<?php
ob_start();

include '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Invoice";
$breadcrumb_item_active = "Payment";

// Fetch invoice details
$id = $_GET['id'];
$db = dbConn();
$sql = "SELECT iv.*, s.SupplierName
        FROM invoices iv
        INNER JOIN supplier s ON s.id=iv.supplier_id
        WHERE iv.id='$id'";
$result = $db->query($sql);
$invoice = $result->fetch_assoc();

// Check POST request and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $amount = dataClean($amount);
    $payment_date = dataClean($payment_date);
    $invoice_id = dataClean($invoice_id);


    $message = array();
    if (empty($amount)) {
        $message['amount'] = "The amount should not be blank...!";
    }
    if (empty($payment_date)) {
        $message['payment_date'] = "The payment date should not be blank...!";
    }

    if (empty($message)) {
        $userid = $_SESSION['USERID'];
        $sql = "SELECT Email, FirstName FROM customers WHERE UserId='$userid'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $Email = $row['Email'];
        $FirstName = $row['FirstName'];

        $date = date('Y-m-d');
        $payment_number = 'py-' . date('YmdHis');

        // Prepare and execute the INSERT query
     echo   $sql = "INSERT INTO supplier_payments (supplier_id, invoice_id, amount, payment_date, payment_number)
                VALUES ('{$invoice['supplier_id']}', '$invoice_id', '$amount', '$payment_date', '$payment_number')";
        $db->query($sql);

        // File upload handling
        if (isset($_FILES['paymentSlip'])) {  // Check if a file is uploaded
            $paymentslip = $_FILES['paymentSlip'];
            $uploadResult = uploadSlip($paymentslip); // Call to function

            if ($uploadResult['upload']) {
                $payment_slip = $uploadResult['file'];
               echo $sql = "UPDATE supplier_payments SET payment_slip='$payment_slip'";
                $db->query($sql);
            } else {
                $messages['paymentSlip'] = $uploadResult['error'];
            }
        }


        if (empty($message)) {
            header("Location: invoice.php");
            exit();
        }
    }
}

function uploadSlip($file) {
    $messages = array();

    if (!empty($file['name'])) {
        $filename = $file['name'];
        $filetmp = $file['tmp_name'];
        $filesize = $file['size'];
        $fileerror = $file['error'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed_ext = array('pdf', 'png', 'jpg', 'gif', 'jpeg');

        if (in_array($file_ext, $allowed_ext)) {
            if ($fileerror === 0) {
                if ($filesize <= 4097152) {
                    $file_name = uniqid('', true) . '.' . $file_ext;
                    $file_destination = '../../payments/' . $file_name;
                    move_uploaded_file($filetmp, $file_destination);
                    $messages['upload'] = true;
                    $messages['file'] = $file_name;
                } else {
                    $messages['upload'] = false;
                    $messages['error'] = "The file size is too large for $filename";
                }
            } else {
                $messages['upload'] = false;
                $messages['error'] = "Error occurred while uploading $filename";
            }
        } else {
            $messages['upload'] = false;
            $messages['error'] = "Invalid file type for $filename";
        }
    } else {
        $messages['upload'] = false;
        $messages['error'] = "No file was uploaded";
    }

    return $messages;
}
?>

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
                <form action="<?= SYS_URL ?>payments/process_payment.php" method="post" enctype="multipart/form-data" novalidate>
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

<?php
$content = ob_get_clean();
include '../layouts.php';
?>
