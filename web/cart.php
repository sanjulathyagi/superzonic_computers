<?php
ob_start();



include '../config.php';
include '../function.php';
include 'header.php';
extract($_POST);


// Ensure that 'cart' is always an array
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
?>
<?php
$discount_percentage=0;


  if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$operate=='calcoupon'){
    $_SESSION['action']="check_coupon";
    if(!isset($_SESSION['USERID'])){
        header("Location: login.php");
        exit();
    }
    $coupon_code=$_POST['coupon'];

    $db = dbConn();
    $user_id = $_SESSION['USERID'];


   echo $sql_customer = "SELECT CustomerId
    FROM customers
    WHERE UserId = '$user_id'";
    $result_customer = $db->query($sql_customer);
    
  if($result_customer->num_rows>0){
    $customer=$result_customer->fetch_assoc();
    $CustomerId=$customer['CustomerId'];
  }  
 //check the coupon table for a match record
   
    $sql_coupon = "SELECT c.customer_id,c.coupon_code ,d.discount_percentage
    FROM coupons c
    LEFT JOIN discount_criteria d
    ON d.id = c.discount_criteria_id
    WHERE status = 1 AND customer_id='$CustomerId' AND coupon_code='$coupon_code'";
    $result_coupon = $db->query($sql_coupon);

    if($result_coupon->num_rows >0){
        $coupon = $result_coupon->fetch_assoc();
        $discount_percentage=$coupon['discount_percentage'];
        
    }else{
        $discount_percentage =0;
    }


  }
//   $_SESSION['total']=$total;  
//   $_SESSION['discount']=$discount;
//   $_SESSION['net_total']=$net_total;  
    

// submit data through hyperlink used extract
// remove the array and subarray record when unset
extract($_GET);
if($_SERVER['REQUEST_METHOD']=='GET' && @$action=='del'){
   $cart=$_SESSION['cart'];
   unset($cart[$id]);
   $_SESSION['cart']=$cart;
}
if($_SERVER['REQUEST_METHOD']=='GET' && @$action=='empty'){
    $_SESSION['cart']=array();
}
// check the method is get and if action parameter exists ,equal to update qty
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update_qty') {
    $cart = $_SESSION['cart'];
  echo  $id = $_POST['id'];
    $qty = $_POST['qty'];
                        
    if (isset($cart[$id])) {
        $cart[$id]['qty'] = $qty;
        $_SESSION['cart'] = $cart;
    }
}
$discount = ($total * $discount_percentage) / 100;
$net_total = $total - $discount;

$_SESSION['total'] = $total;
$_SESSION['discount'] = $discount;
$_SESSION['net_total'] = $net_total;
?>

<style>
    .cart_count {
        background-color: red;
        color: white;
        border-radius: 50%;
        width: 20px;
        top: 12px;
        right: 20px;
        font-size: 12px;
        padding: 5px 10px;

    }
</style>

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

    </section><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="cart-wrapper">
                <?php if (empty($_SESSION['cart'])): ?>
                        <p>Your cart is empty.</p>
                        <a href="item.php" class="btn btn-warning">Go to Shop</a>
                    <?php else: ?>
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- foreach used to read associative array in cart session array of array -->
                            <?php
                        $total = 0;
                       
                        foreach ($_SESSION['cart'] as $key => $value) {
                        ?>
                            <tr>
                                <td><?= $key ?></td>
                                <td><img src="../uploads/<?=  $value['ImagePath'] ?>" alt="Item Image" width="100"
                                        height="100"></td>
                                <td><?= $value['item_name'] ?></td>
                                <td><?= $value['unit_price'] ?></td>
                                <td>
                                    <form method="post" action="cart.php">
                                        <input type="hidden" name="id" value="<?= $key ?>">
                                        <input type="hidden" name="action" value="update_qty">
                                        <input type="number" value="<?= $value['qty'] ?>" name="qty" min="1"
                                            onchange="form.submit()">

                                    </form>

                                </td>
                                <td><?php $amount=$value['unit_price']*$value['qty']; $total+=$amount; echo number_format($amount,2) ; ?>
                                </td>
                                <!-- key= stock id of outer array -->
                                <td><a href="cart.php?id=<?= $key ?>&action=del" class="remove-item-btn bg-warning "><i
                                            class="fas fa-trash btn-sm"></i></a>
                                </td>
                            </tr>
                            <?php
                             
                        }
                    
                        ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="4">Total</td>
                                <td colspan="2"><?= number_format($_SESSION['total'], 2) ?></td>

                            </tr>
                            <tr>
                                <td colspan="4">Discount(coupon)</td>
                                <td colspan="2"><?= number_format($_SESSION['discount'] ,2)?></td>
                            </tr>
                            <tr>
                                <td colspan="4">Net Total</td>
                                <td colspan="2"><?= number_format($_SESSION['net_total'], 2) ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group ">
                                    <label for="inputCoupon"><b>Coupon Code</b></label>
                                    <input type="text" class="form-control" id="coupon" name="coupon"
                                        placeholder="Enter Coupon"><br>

                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group "><br>
                                    <button type="submit" class="btn btn-warning btn-sm " name="operate"
                                        value="calcoupon">Apply
                                        Coupon</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <a href="cart.php?action=empty" class="empty-cart-btn bg-danger btn-sm">Empty Cart</a>
                    <?php endif; ?>
                </div>
                <section id="services" class="services">
                    <div class="container" data-aos="fade-up">
                        <div class="section-title">
                            <p>Cart Summary</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="row">
                                <div class="col-lg-8  align-items-stretch" data-aos="zoom-in">
                                    <div class="icon-box" style="width:1000 !important;">
                                        <img src="<?= WEB_URL ?>assets/img/OIP (1).jpeg" alt="laptop" class="first-img"
                                            style="height:200px !important;width:200px !important;">
                                        <h4>Power up your cart!</h4>
                                        <!-- <div class="icon"><i class="bx bxl-dribbble"></i></div> -->
                                        <table class="cart-table ">
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4">Total</td>
                                                    <td colspan="2"><?= number_format($_SESSION['total'], 2) ?></td>

                                                </tr>
                                                <tr>
                                                    <td colspan="4">Discount(coupon)</td>
                                                    <td colspan="2"><?= number_format($_SESSION['discount'] ,2)?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Net Total</td>
                                                    <td colspan="2"><?= number_format($_SESSION['net_total'], 2) ?></td>
                                                   
                                                </tr>
                                            </tfoot>
                                        </table>
          
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="checkout.php" method="post">
                            <input type="hidden" name="total" value="<?= number_format($_SESSION['total'], 2) ?>">
                            <input type="hidden" name="discount" value="<?= number_format($_SESSION['discount'] ,2)?>">
                            <input type="hidden" name="net_total" value="<?= number_format($_SESSION['net_total'], 2) ?>">
                            <button type="submit" class="btn btn-warning btn-sm" name="operate"
                                value="checkout">Checkout</button>
                        </form>

                        <!-- <a href="checkout.php" class="btn btn warning">checkout</a> -->
                    </div>
                </section>
            </div>
        </div>
    </div>


    <?php
include 'footer.php';
ob_end_flush();
?>