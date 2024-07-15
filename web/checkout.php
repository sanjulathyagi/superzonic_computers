<?php
include 'header.php';
session_start();

include '../function.php';
//submit form data clean 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $delivery_name = dataClean($delivery_name);
    $delivery_address = dataClean($delivery_address);
    $delivery_phone = dataClean($delivery_phone);
    $billing_name = dataClean($billing_name);
    $billing_address = dataClean($billing_address);
    $billing_phone = dataClean($billing_phone);

    $message = array();
    //Required validation-----------------------------------------------
    if (empty($delivery_name)) {
        $message['delivery_name'] = "The delivery name should not be blank...!";
    }
    if (empty($delivery_address)) {
        $message['delivery_address'] = "The delivery address is required";
    }
    if (empty($delivery_phone)) {
        $message['delivery_phone'] = "The delivery phone should not be blank...!";
    }
    if (!isset($billing_name)) {
        $message['billing_name'] = "The billing name is required";
    }
    if (empty($billing_address)) {
        $message['billing_address'] = "The billing address is required";
    }
    if (empty($billing_phone)) {
        $message['billing_phone'] = "The billing phone is required";
    }
// find customerid from userid when login
    if (empty($message)) {
        $db = dbConn();
        $userid = $_SESSION['USERID'];
        $sql = "SELECT CustomerId FROM customers WHERE UserId='$userid'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $customerid = $row['CustomerId'];
        $order_date = date('Y-m-d');
        $order_number = date('Y') . date('m') . date('d') . $customerid;
        
        $sql = "INSERT INTO 'orders'('order_date','customer_id','delivery_name','delivery_address','delivery_phone','billing_name','billing_address','billing_phone','order_number') VALUES ('$order_date','$customerid','$delivery_name','$delivery_address','$delivery_phone','$billing_name','$billing_address','$billing_phone','$order_number')";
        $db->query($sql);
        // last insert order id of last record
        $order_id = $db->insert_id;

        $cart = $_SESSION['cart'];
        $_SESSION['order_number']=$order_number;

        foreach ($cart as $key => $value) {
            $stock_id = $value['stock_id'];
            $item_id = $value['item_id'];
            $unit_price = $value['unit_price'];
            $qty = $value['qty'];
            $sql = "INSERT INTO `order_items`(`order_id`,`item_id`,`stock_id`,`unit_price`,`qty`) VALUES ('$order_id','$item_id','$stock_id','$unit_price','$qty')";
            $db->query($sql);
        }
        header("Location:order_success.php");
    }
}
?>


<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <div class="container">
                    <h4>Checkout form</h4>
                    <div class="d-flex justify-content-between align-items-center">

                        <a href="cart.php" style="margin-left:1150px !important;text-align:right;"><i
                                class="fa fa-shopping-cart"></i></a>
                        <a href="appointment.php" style="text-align:right;"><i class="fas fa-laptop-house"></i></a>
                        <a href="contact.php"><i class="fas fa-phone"></i></a>

                    </div>

                </div>

            </div>

        </div>

    </section><br><!-- End Breadcrumbs -->

    <div class="container">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="row">
                <div class="col-md-6">
                    <h3>Delivery Details</h3>
                    <div class="form-group">
                        <label for="delivery_name">Name:</label>
                        <input type="text" class="form-control" id="delivery_name" name="delivery_name" required>
                    </div>
                    <div class="form-group">
                        <label for="delivery_address">Address:</label>
                        <textarea class="form-control" id="delivery_address" name="delivery_address" rows="3"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="delivery_phone">Phone:</label>
                        <input type="text" class="form-control" id="delivery_phone" name="delivery_phone" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>Billing Details</h3>
                    <div class="form-group">
                        <label for="billing_name">Name:</label>
                        <input type="text" class="form-control" id="billing_name" name="billing_name" required>
                    </div>
                    <div class="form-group">
                        <label for="billing_address">Address:</label>
                        <textarea class="form-control" id="billing_address" name="billing_address" rows="3"
                            required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="billing_phone">Phone:</label>
                        <input type="text" class="form-control" id="billing_phone" name="billing_phone" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="checkbox" id="same_as_delivery" name="same_as_delivery" class="form-check-input">
                <label for="same_as_delivery" class="form-check-label">Same as Delivery Details</label>
            </div><br>
            <button type="submit" class="btn btn-warning">Checkout</button>
        </form>
    </div><br>


    <script>
        // Script to copy delivery details to billing details
        document.getElementById('same_as_delivery').addEventListener('change', function () {
            if (this.checked) {
                document.getElementById('billing_name').value = document.getElementById('delivery_name')
                    .value;
                document.getElementById('billing_address').value = document.getElementById(
                    'delivery_address').value;
                document.getElementById('billing_phone').value = document.getElementById('delivery_phone')
                    .value;
            } else {
                document.getElementById('billing_name').value = '';
                document.getElementById('billing_address').value = '';
                document.getElementById('billing_phone').value = '';
            }
        });
    </script>

</main>

<?php
include 'footer.php';
?>