<?php

include '../config.php';
include 'header.php';
include '../function.php';


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
        <?php   
                $db = dbConn();
                $sql = "SELECT i.*, b.brand, m.model_name, ic.category_name,im.ImagePath,s.*
                FROM items i 
                INNER JOIN item_stock s ON s.item_id = i.id
                INNER JOIN item_category ic ON ic.id = i.item_category 
                INNER JOIN brands b ON b.id = i.brand_id 
                INNER JOIN models m ON m.id = i.model_id 
                INNER JOIN itemimages im ON im.ItemID = i.id  GROUP BY i.id;";
                $result1 = $db->query($sql);
                ?>
    </section><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <section id="services" class="services">
                    <div class="container" data-aos="fade-up">
                        <div class="section-title">
                            <p>Cart Summary</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="row">
                                <div class="col-lg-8  align-items-stretch" data-aos="zoom-in">
                                    <div class="icon-box" style="width:1000 !important;">
                                        <!-- <img src="<?= WEB_URL ?>assets/img/OIP (1).jpeg" alt="laptop" class="first-img"
                                            style="height:200px !important;width:200px !important;">
                                        <h4>Power up your cart!</h4> -->
                                        <!-- <div class="icon"><i class="bx bxl-dribbble"></i></div> -->
                                        <table class="cart-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Item Name</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <!-- foreach used to read associative array in cart session array of array -->
                            <?php
                        $total = 0;
                        while ($row = $result1->fetch_assoc()) {
                        foreach ($_SESSION['cart'] as $key => $value) {
                        ?>
                            <tr>
                                <td><?= $key ?></td>
                                <td><img src="../uploads/<?=  $row['ImagePath'] ?>" alt="Item Image"
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
                                
                                
                            </tr>
                            <?php
                            $total += $value['unit_price'] * $value['qty'];
                        }
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