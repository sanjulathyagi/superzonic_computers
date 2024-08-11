<?php

include '../config.php';
include 'header.php';
include '../function.php';

extract($_POST); 
if(!isset($_SESSION['USERID'])){
    header("Location:login.php");
}


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
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'update_qty') {
    $cart = $_SESSION['cart'];
    $cart = $_GET['id'];
    $qty = $_GET['qty'];
    

  $db = dbConn();
  $sql = "SELECT (issued_qty-qty) FROM item_stocks
  where item=id";
  $result = $db->query($sql);
  $row = $result->fetch_assoc();
  $available_qty=$row['available_qty'];
  if($available_qty<= $qty){
    $qty=$available_qty;
  }
  
                                
    if (isset($cart[$id])) {
        $cart[$id]['qty'] = $qty;
        $_SESSION['cart'] = $cart;
    }
}
// if ($_SERVER['REQUEST_METHOD']== 'GET' && @$action == 'update_qty'){
//     $current_qty = $_SESSION['cart'][$id]['qty'];
//     if(!empty($qty)) {
//         $current_qty= $qty;
//     }
//     $_SESSION['cart']['$id']['qty'] = $current_qty;
// }

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
                                <td><img src="../uploads/<?=  $value['ImagePath'] ?>" alt="Item Image"
                                        width="10%" height="10%"></td>
                                <td><?= $value['item_name'] ?></td>
                                <td><?= $value['unit_price'] ?></td>
                                <td>
                                    <form method="get" action="cart.php">
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
                            $total += $value['unit_price'] * $value['qty'];
                        }
                    
                        ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">Total</td>
                                <td colspan="2"><?= number_format($total, 2) ?></td>
                            </tr>
                            <tr>
                                <td colspan="4">Discount(3%)</td>
                                <td colspan="2"><?= number_format($total * 0.03, 2) ?></td>
                            </tr>
                            <tr>
                                <td colspan="4">Net</td>
                                <td colspan="2"><?= number_format(($total - $total * 0.03), 2) ?></td>
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
                                    <button type="submit" class="btn btn-warning btn-sm ">Apply Coupon</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <a href="cart.php?action=empty" class="empty-cart-btn bg-danger btn-sm">Empty Cart</a>
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
                                                    <td colspan="2"><?= number_format($total, 2) ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Discount(3%)</td>
                                                    <td colspan="2"><?= number_format($total * 0.03, 2) ?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">Net</td>
                                                    <td colspan="2"><?= number_format(($total - $total * 0.03), 2) ?>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="checkout.php" class="checkout-btn bg-dark btn-sm">Checkout</a>
                    </div>
                </section>
            </div>
        </div>
    </div>


    <?php
include 'footer.php';
?>