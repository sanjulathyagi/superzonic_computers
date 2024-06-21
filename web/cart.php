<?php
include 'header.php';
session_start(); 
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
    if (isset($cart[$id])) {
        $cart[$id]['qty'] = $qty;
        $_SESSION['cart'] = $cart;
    }
}

?>



<main id="main">
    <section class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <div class="container">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="shopping_cart.php" style="margin-left:1150px !important;text-align:right;"><i
                                class="fa fa-shopping-cart"></i></a>
                        <a href="appointment.php" style="text-align:right;"><i class="fas fa-laptop-house"></i></a>
                        <a href="contact.php"><i class="fas fa-phone"></i></a>

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
                                <td><img src="web/assets/img/<?= $row['item_image'] ?>" alt="Item Image" width="100%"
                                        height="100%"></td>
                                <td><?= $value['item_name'] ?></td>
                                <td><?= $value['unit_price'] ?></td>
                                <td>
                                    <form method="get" action="cart.php">
                                        <input type="hidden" name="id" value="<?= $key ?>">
                                        <input type="hidden" name="action" value="update_qty">
                                        <input type="number" value="<?= $value['qty'] ?>" name="qty" min="0"
                                            onchange="form.submit()">

                                    </form>
                                </td>
                                <td><?php $amount=$value['unit_price']*$value['qty']; $total+=$amount; echo number_format($amount,2) ; ?>
                                </td>
                                <!-- key= stock id of outer array -->
                                <td><a href="cart.php?id=<?= $key ?>&action=del" class="remove-item-btn bg-warning"><i
                                            class="fas fa-trash"></i></a>
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
                    <a href="checkout.php" class="checkout-btn bg-dark">Checkout</a>
                    <a href="cart.php?action=empty" class="empty-cart-btn bg-danger">Empty Cart</a>
                </div>
            </div>
        </div>
    </div>

<?php
include 'footer.php';
?>