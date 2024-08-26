<?php
ob_start();
session_start(); // Start session

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config.php';
include 'header.php';
include '../function.php';
include '../mail.php';

// Initialize the variables
$amount = '';
$date = '';
$payment_slip = '';
$messages = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $order_number = $_SESSION['order_number']; // Use session to retrieve order number
    $amount = dataClean($amount);
    $date = dataClean($date);

    // Validate input
    if (empty($amount)) {
        $messages['amount'] = "The amount should not be blank!";
    }
    if (empty($date)) {
        $messages['date'] = "The date should not be blank!";
    }
   
    if (empty($messages)) {
        $db = dbConn();
        $userid = $_SESSION['USERID'];
        $sql = "SELECT CustomerId,Email,FirstName FROM customers WHERE UserId='$userid'";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $customerid = $row['CustomerId'];
            $Email = $row['Email'];
            $FirstName = $row['FirstName'];
            
            $payment_number = 'py-' . date('YmdHis') . $customerid;

            $sql = "INSERT INTO payments(payment_number, order_number, amount, date) VALUES ('$payment_number', '$order_number', '$amount', '$date')";
            $db->query($sql);

            $_SESSION['payment_number'] = $payment_number;

            if (isset($_FILES['paymentSlip'])) {  // Check if a file is uploaded
                $paymentslip = $_FILES['paymentSlip'];
                $uploadResult = uploadSlip($paymentslip); // Call to function

                if ($uploadResult['upload']) {
                    $payment_slip = $uploadResult['file'];
                    $sql = "UPDATE payments SET payment_slip='$payment_slip' WHERE payment_number='$payment_number'";
                    $db->query($sql);
                } else {
                    $messages['paymentSlip'] = $uploadResult['error'];
                }
            }

            // Sending email
            $msg = "<h1>Payment Confirmation</h1>";
            $msg .= "<h2>Thank you for your payment, $FirstName</h2>";
            $msg .= "<p>We have received your payment successfully and your order is now being processed.</p>";
            $msg .= "<p>You can track your order status and view the details by clicking the link below:</p>";
            $msg .= "<p>If you have any questions or need further assistance, feel free to contact our support team.</p>";
            $msg .= "<p>Thank you for shopping with us!</p>";
            $msg .= "<p><b>SuperZonic Computers</b></p>";
            $msg .= "<p><b>NO. 50/1 <br>NIDHAS MAWATHA<br>KEGALLE</b></p>";
            $msg .= "<p><strong>Phone:</strong> +94 771153923</p>";
            $msg .= "<p><strong>Email:</strong> superzonic@gmail.com</p>";

            sendEmail($Email, $FirstName, "Payment Confirmation", $msg);

            if (empty($messages)) {
                header("Location: payment_success.php");
                exit();
            }
        } else {
            $messages['db_error'] = "User information could not be retrieved.";
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
        $file_ext = strtolower(end(explode('.', $filename)));
        $allowed_ext = array('pdf', 'png', 'jpg', 'gif', 'jpeg');

        if (in_array($file_ext, $allowed_ext)) {
            if ($fileerror === 0) {
                if ($filesize <= 4097152) {
                    $file_name = uniqid('', true) . '.' . $file_ext;
                    $file_destination = '../uploads/payments/' . $file_name;
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

// Check if the order number session variable is set
if (!isset($_SESSION['order_number'])) {
    // Redirect to the item page if the order number session is not set
    header("Location: item.php");
    exit();
}
?>

<main id="main">
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-lg-6">
            <section id="services" class="services">
                <div class="container" data-aos="fade-up">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="row">
                            <div class="align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                                <div class="icon-box" style="width:600px;height:400px !important;">
                                    Your Order Number is <?= htmlspecialchars($_SESSION['order_number'], ENT_QUOTES, 'UTF-8') ?>
                                    <h4>Bank Transfer Details</h4>
                                    When you make payments, please transfer directly to our bank account. Ensure that
                                    you include your order number as the payment reference. Your order will be processed
                                    only after the funds are cleared.<br><br>

                                    Bank : Commercial Bank<br>
                                    Branch : Kegalle<br>
                                    Account Name : Superzonic Computer Store<br>
                                    Account Number : 8019327459<br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="col-lg-5">
            <section id="services" class="services">
                <div class="container" data-aos="fade-up">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card card-dark">
                            <div class="card-header">
                                <h4 class="card-title">Payment Details</h4>
                            </div>
                            <div class="card-body">
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                                    class="form-group" enctype="multipart/form-data" novalidate>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="inputOrderNumber">Order Number</label>
                                            <input type="text" class="form-control"
                                                value="<?= htmlspecialchars($_SESSION['order_number'], ENT_QUOTES, 'UTF-8') ?>"
                                                readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputAmount">Amount</label>
                                            <input type="text" class="form-control" id="amount" name="amount"
                                                placeholder="Enter amount" value="<?= htmlspecialchars(@$amount) ?>">
                                                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($messages['amount'])): ?>
                                                <span class="text-danger"><?= htmlspecialchars($messages['amount']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDate">Date</label>
                                            <input type="date" class="form-control" id="date" name="date"min="<?=date('Y-m-d')?>"
                                                value="<?= htmlspecialchars(@$date) ?>">
                                                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($messages['date'])): ?>
                                                <span class="text-danger"><?= htmlspecialchars($messages['date']) ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputFile">Upload Payment Slip</label>
                                            <input type="file" class="form-control" id="paymentSlip" name="paymentSlip">
                                                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($messages['paymentSlip'])): ?>
                                                <span class="text-danger"><?= htmlspecialchars($messages['paymentSlip']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-warning btn-sm">Submit</button>
                                       
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
