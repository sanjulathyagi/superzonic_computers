<?php
ob_start();
include '../config.php';
include 'header.php';
include '../function.php';

if (!isset($_SESSION['USERID'])) {
    header("Location:login.php");
}


//submit form data clean 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $delivery_name = dataClean($delivery_name);
    $delivery_address = dataClean($delivery_address);
    $delivery_email = dataClean($delivery_email);
    $delivery_phone = dataClean($delivery_phone);

    $billing_name = dataClean($billing_name);
    $billing_address = dataClean($billing_address);
    $billing_email = dataClean($billing_email);
    $billing_phone = dataClean($billing_phone);

    $message = array();
    //Required validation-----------------------------------------------
    if (empty($delivery_name)) {
        $message['delivery_name'] = "The delivery name should not be blank...!";
    }
    if (empty($delivery_address)) {
        $message['delivery_address'] = "The delivery address is required";
    }
    if (empty($delivery_email)) {
        $message['delivery_email'] = "The email is required";
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
    if (empty($billing_email)) {
        $message['billing_email'] = "The email is required";
    }
    if (empty($billing_phone)) {
        $message['billing_phone'] = "The billing phone is required";
    }

// $delivery_fee =0;  

// $delivery_method = $_POST['delivery_method']?? '';
// $total=$_POST['total'];
// $discount_amount= $_POST['discount_amount'];

// if($delivery_method === 'delivery'){
//     if($total<= 9999){
//         $delivery_fee = 350;
//     }elseif($total<= 19999){
//         $delivery_fee = 600;
//     }elseif($total<= 49999){
//         $delivery_fee = 900;
//     }elseif($total<= 99999){
//         $delivery_fee = 1200;
//     }elseif($total<= 149999){
//         $delivery_fee = 1500;
//     }else{
//         $delivery_fee = 2000;
  
//     }
// } else{
//     $delivery_fee = 0;
// }

$net_total =$total - $discount_amount + $delivery_fee;

// find customerid from userid when login
    if (empty($message)) {
        $db = dbConn();
        $userid = $_SESSION['USERID'];
        $sql = "SELECT CustomerId FROM customers WHERE UserId='$userid'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $customerid = $row['CustomerId'];
        $order_date = date('Y-m-d');
        $order_number = date('YmdHis') . $customerid;
        
        // last insert order id of last record
        $sql = "INSERT INTO orders(order_date,customer_id,delivery_name,delivery_address,delivery_email,delivery_phone,billing_name,billing_address,billing_email,billing_phone,order_number,delivery_method,total_amount) 
        VALUES ('$order_date','$customerid','$delivery_name','$delivery_address','$delivery_email','$delivery_phone','$billing_name','$billing_address','$billing_email','$billing_phone','$order_number','$delivery_method','$net_total')";
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
            $sql = "INSERT INTO order_items(order_id,item_id,stock_id,unit_price,qty) VALUES ('$order_id','$item_id','$stock_id','$unit_price','$qty')";
            $db->query($sql);
        }
        header("Location:order_success.php");
        unset($_SESSION['cart']);
    }
}
?>



<section class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">

                </div>

            </div>

        </div>

    </div>

</section><br>

<main id="main">
    <div class="container">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="row">
                <div class="col-lg-8">

                    <div class="row">
                        <div class="col-lg-8">
                            <h3>Delivery Details</h3>
                            <label for="delivery_name">Name:</label>
                            <input type="text" id="delivery_name" name="delivery_name" class="form-control"
                                required><br>

                            <label for="delivery_address">Address:</label>
                            <textarea id="delivery_address" name="delivery_address" class="form-control"
                                required></textarea><br>

                            <label for="delivery_phone">Email:</label>
                            <input type="text" class="form-control" id="delivery_email" name="delivery_email"
                                class="form-control" required>

                            <label for="delivery_phone">Phone:</label>
                            <input type="text" id="delivery_phone" name="delivery_phone" class="form-control"
                                required><br>

                            <div class="row">
                                <div class="col-lg-6">

                                    <label for="Payment Methods"><b>Delivery Method</b></label><br>
                                    <input type="radio" id="delivery" value="delivery" name="delivery_method">Delivery
                                    <br>
                                    <input type="radio" id="pickup" value="pickup" name="delivery_method">Pickup from
                                    store


                                </div>
                                <div class="col-lg-6">

                                    <label for="Payment Methods"><b>Payment Method</b></label><br>
                                    <input type="radio" id="cod" value="cod" name="payment_method"> Cash On Delivery
                                    (COD)<br>
                                    <input type="radio" id="bank" value="bank" name="payment_method"> Bank
                                    Transfer


                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="same_as_delivery" name="same_as_delivery" class="form-check-input">
                        <label for="same_as_delivery" class="form-check-label">Same as Delivery Details</label>
                    </div><br>
                    <div class="row">
                        <div class="col-lg-8">
                            <h3>Billing Details</h3>
                            <label for="billing_name">Name:</label>
                            <input type="text" id="billing_name" name="billing_name" class="form-control" required><br>

                            <label for="billing_address">Address:</label>
                            <textarea id="billing_address" name="billing_address" class="form-control"
                                required></textarea><br>

                            <label for="billing_phone">Email:</label>
                            <input type="text" class="form-control" id="billing_email" name="billing_email"
                                class="form-control" required>

                            <label for="billing_phone">Phone:</label>
                            <input type="text" id="billing_phone" name="billing_phone" class="form-control"
                                required><br>

                        </div>
                    </div><br>

                </div>
                <div class="col-lg-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="row bg-light ">
                            <div class="col-lg-8  align-items-stretch" data-aos="zoom-in">
                                <div class="icon-box" style="width:400 !important;">
                                    <img src="<?= WEB_URL ?>assets/img/credit-card.avif" alt="laptop" class="first-img"
                                        style="height:200px !important;width:200px !important;">
                                    <h5>Seal the deal—checkout now!</h5>
                                    <table class="cart-table ">
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">Total</td>
                                                <td colspan="2"><?= number_format($total, 2) ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">Discount(coupon)</td>
                                                <td colspan="2"> <?= number_format(($total * $discount_percentage)/100 ,2)?></td>
                                            </tr>
                                            <!-- calculate the delivery fee -->
                                            <tr>
                                                <td colspan="4">Delivery Fee</td>
                                                <td colspan="2"><?= number_format($delivery_fee ,2) ?></td>
                                            </tr>

                                            <tr>
                                                <td colspan="4">Net Total</td>
                                                <td colspan="2"><?= number_format(($total-($total * $discount_percentage)/100), 2) ?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><br><br>
                    <!-- <div class="col-lg-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="row bg-light">
                                <div class="col-lg-8  align-items-stretch" data-aos="zoom-in">
                                    <div class="icon-box" style="width:400 !important;">
                                        <h4>Bank Transfer Details</h4>
                                        When You do payments using Direct Bank Transfer, <br>please make your payment directly to our
                                        bank account. Ensure that you include your order ID as the payment reference.
                                        Please note that your order will be processed and dispatched only after the
                                        funds
                                        have been successfully cleared in our account.<br><br>
                                        <h4>Bank Transfer Details</h4>
                                        Bank : Commercial Bank<br>
                                        Branch : Kegalle<br>
                                        Account Name : Superzonic computer store<br>
                                        Account Number : 8019327459<br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="row bg-light">
                                <div class="col-lg-8  align-items-stretch" data-aos="zoom-in">
                                    <div class="icon-box" style="width:400 !important;">
                                        <h4>Delivery Fee Conditions</h4>
                                        <p>The delivery fee is calculated based on your total amount.</p>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Order Amount</th>
                                                    <th>Delivery Fee</th>
                                                </tr>
                                            <tbody>
                                                <tr>
                                                    <td>Up to Rs.9999 </td>
                                                    <td>Rs.350</td>
                                                </tr>
                                                <tr>
                                                    <td>Rs.10000 to Rs.19999 </td>
                                                    <td>Rs.600</td>
                                                </tr>
                                                <tr>
                                                    <td>Rs.20000 to Rs.49999 </td>
                                                    <td>Rs.900</td>
                                                </tr>
                                                <tr>
                                                    <td>Rs.50000 to Rs.99999 </td>
                                                    <td>Rs.1200</td>
                                                </tr>
                                                <tr>
                                                    <td>Rs.100000 to Rs.149999 </td>
                                                    <td>Rs.1500</td>
                                                </tr>
                                                <tr>
                                                    <td>Rs.150000 to above </td>
                                                    <td>Rs.2000</td>
                                                </tr>
                                            </tbody>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
            <button type="submit" class="btn btn-warning">Checkout</button>
        </form>
    </div><br>
</main>
<script>
    // Script to copy delivery details to billing details
    document.getElementById('same_as_delivery').addEventListener('change', function () {
        if (this.checked) {
            document.getElementById('billing_name').value = document.getElementById('delivery_name').value;
            document.getElementById('billing_address').value = document.getElementById('delivery_address')
                .value;
            document.getElementById('billing_email').value = document.getElementById('delivery_email')
                .value;
            document.getElementById('billing_phone').value = document.getElementById('delivery_phone')
                .value;
        } else {
            document.getElementById('billing_name').value = '';
            document.getElementById('billing_address').value = '';
            document.getElementById('billing_email').value = '';
            document.getElementById('billing_phone').value = '';
        }
    });
</script>



<?php
include 'footer.php';
ob_end_flush();
?>