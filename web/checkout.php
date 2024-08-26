<?php
ob_start();
include '../config.php';
include 'header.php';
include '../function.php';
include '../mail.php';

if (!isset($_SESSION['USERID'])) {
    header("Location:login.php");
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
//submit form data clean 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $total = $_SESSION['total']; 
    $discount = $_SESSION['discount']; 
    $net_total = $_SESSION['net_total'];
   

    $delivery_name = dataClean($delivery_name);
    $delivery_address = dataClean($delivery_address);
    $delivery_email = dataClean($delivery_email);
    $delivery_phone = dataClean($delivery_phone);

    $billing_name = dataClean($billing_name);
    $billing_address = dataClean($billing_address);
    $billing_email = dataClean($billing_email);
    $billing_phone = dataClean($billing_phone);


    $delivery_cost=0;

    $db=dbConn();
    if ($delivery_method=='delivery'){
       $sql="SELECT delivery_cost FROM districts
        WHERE Id='$delivery_district'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $delivery_cost = $row['delivery_cost'];
        }
    }elseif($delivery_method=='pickup'){
        $delivery_cost=0;
    }

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
 

// find customerid from userid when login
    if (empty($message)) {
        $db = dbConn();
        $userid = $_SESSION['USERID'];
        $sql = "SELECT CustomerId, FirstName,Email FROM customers WHERE UserId='$userid'";
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        $customerid = $row['CustomerId'];
        $FirstName = $row['FirstName'];
        $Email = $row['Email'];
        $order_date = date('Y-m-d');
        $order_number ='Or-'. date('YmdHis') . $customerid;
        
        // last insert order id of last record
       $sql = "INSERT INTO orders(order_date,customer_id,delivery_name,delivery_address,delivery_district,delivery_email,delivery_phone,billing_name,billing_address,billing_email,billing_phone,order_number,delivery_method,payment_method,total,total_amount,discount,delivery_cost) 
        VALUES ('$order_date','$customerid','$delivery_name','$delivery_address','$delivery_district','$delivery_email','$delivery_phone','$billing_name','$billing_address','$billing_email','$billing_phone','$order_number','$delivery_method','$payment_method','$total','$net_total','$discount','$delivery_cost')";
        $db->query($sql);
        // last insert order id of last record
        $order_id = $db->insert_id;

        $cart = $_SESSION['cart'];
        $_SESSION['order_number']=$order_number;
        $_SESSION['order_id']=$order_id;

        $total = $_SESSION['total'];
        $discount = $_SESSION['discount'];
        $net_total = $_SESSION['net_total'];
        $net_total=($total-$discount)+$delivery_cost;


        foreach ($cart as $key => $value) {
            $stock_id = $value['stock_id'];
            $item_id = $value['item_id'];
            $unit_price = $value['unit_price'];
            $qty = $value['qty'];
            $sql = "INSERT INTO order_items(order_id,item_id,stock_id,unit_price,qty) VALUES ('$order_id','$item_id','$stock_id','$unit_price','$qty')";
            $db->query($sql);
            
            //sending email
            $msg="<h1>Order Confirmation</h1>";
            $msg.="<h2>Thank you For your Purchase, $FirstName</h2>";
            $msg.="<p>We are pleased to inform you that Your order has been successfully placed</p>";
            $msg="<a href='http://localhost/SIRMS/web/order_summary.php?order_id=" .$order_id ."'>Click here to verify your order and track your order status</a>";
            $msg.="<p>If you have any questions or need further assistance, feel free to contact our support team.</p>";
            $msg.="<p>Thank you for shopping with Us!</p>";

            $msg.="<p><b>SuperZonic Computers</b></p>";
            $msg.="<p><b> NO. 50/1 <br>
                              NIDHAS MAWATHA<br>
                              KEGALLE<b></p>";
            $msg.=" <p><strong>Phone:</strong> +94 771153923</p>";
            $msg.="<p><strong>Email:</strong> superzonic@gmail.com</p>";
            sendEmail($Email,$FirstName,"Order Verification",$msg);
        }
        header("Location:order_success.php?order_id=" . $order_id);

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
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
            <div class="row">
                <div class="col-lg-8">
                    <h3>Delivery Details</h3>
                    <div class="row">
                        <div class="col-lg-6">

                            <label for="Payment Methods"><b>Delivery Method</b></label><br>
                            <input type="radio" id="delivery" value="delivery" name="delivery_method"
                                <?= @$delivery_method == 'delivery' ? 'checked' : '' ?>>Delivery
                            <br>
                            <input type="radio" id="pickup" value="pickup" name="delivery_method"
                                <?= @$delivery_method == 'pickup' ? 'checked' : '' ?>>Pickup from
                            store


                        </div>
                        <div class="col-lg-6">

                            <label for="Payment Methods"><b>Payment Method</b></label><br>
                            <input type="radio" id="cod" value="cod" name="payment_method"
                                <?= @$payment_method == 'cod' ? 'checked' : '' ?>> Cash On Delivery
                            (COD)<br>
                            <input type="radio" id="bank" value="bank" name="payment_method"
                                <?= @$payment_method == 'bank' ? 'checked' : '' ?>> Bank
                            Transfer


                        </div>
                    </div>

                    <div class="row">

                    <div class="col-lg-8">
    <?php
    $db = dbConn();
    $sql = "SELECT * FROM districts";
    $result = $db->query($sql);

    // Initialize selected district variable
    $selectedDistrict = isset($delivery_district) ? $delivery_district : '';
    ?>

    <label for="district">District</label>
    <select name="delivery_district" id="delivery_district" onchange="this.form.submit()"
        class="mb-3 border form-select form-select-lg" aria-label="Large select example">
        <option value="">-- Select District --</option>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <option value="<?= $row['Id'] ?>"
                <?= $selectedDistrict == $row['Id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($row['Name']) ?>
            </option>
        <?php } ?>
    </select>



                            <label for="delivery_name">Name:</label>
                            <input type="text" id="delivery_name" name="delivery_name" class="form-control"
                                value="<?=@$delivery_name ?>" required><br>
                                

                            <label for="delivery_address">Address:</label>
                            <textarea id="delivery_address" name="delivery_address" class="form-control"
                                required> </textarea><br>



                            <label for="delivery_phone">Email:</label>
                            <input type="text" class="form-control" id="delivery_email" name="delivery_email"
                                value="<?=@$delivery_email ?>" class="form-control" required>
                                

                            <label for="delivery_phone">Phone:</label>
                            <input type="text" id="delivery_phone" name="delivery_phone" class="form-control"
                                value="<?=@$delivery_phone ?>" required><br>
                              


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
                            <input type="text" id="billing_name" name="billing_name" class="form-control"
                                value="<?=@$billing_name ?>" required><br>
                              
                            <label for="billing_address">Address:</label>
                            <textarea id="billing_address" name="billing_address" class="form-control"
                                required><?=@$billing_address ?></textarea><br>
                                


                            <label for="billing_phone">Email:</label>
                            <input type="text" class="form-control" id="billing_email" name="billing_email"
                                value="<?=@$billing_email ?>" class="form-control" required>
                                
                            <label for="billing_phone">Phone:</label>
                            <input type="text" id="billing_phone" name="billing_phone" class="form-control"
                                value="<?=@$billing_phone ?>" required><br>
                               
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
                                                <td colspan="2"><?=$_SESSION['total']?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">Discount(coupon)</td>
                                                <td colspan="2">
                                                    <?=$_SESSION['discount']?></td>
                                            </tr>
                                            <!-- calculate the delivery fee -->
                                            <tr>
                                                <td colspan="4">Delivery Fee</td>
                                                <td colspan="2"><?= $delivery_cost ?></td>
                                            </tr>

                                            <tr>
                                                <td colspan="4">Net Total</td>
                                                <td colspan="2">
                                                    <?=$_SESSION['net_total']+$delivery_cost?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><br><br>
                    <div class="col-lg-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="row bg-light">
                                <div class="col-lg-8  align-items-stretch" data-aos="zoom-in">
                                    <div class="icon-box" style="width:400 !important;">
                                        <h4>Delivery Fee Conditions</h4>
                                        <p>The delivery fee is calculated based on your selected district.</p>
                                        <p>Delivery within 3 working days for kegalle, 5 or more working days for other
                                            locations.</p>

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