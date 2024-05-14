<?php
session_start();
extract($_GET);
if($_SERVER['REQUEST_METHOD']=='GET' && @$action=='del'){
    $cart=$_SESSION['cart'];
    unset($cart[$id]);
    $_SESSION['cart']=$cart;
}
?>

<div class="container">
    <section class="shopping_cart">
        <h1 class="shopping_cart">Shopping Cart</h1>
        <table>
            <thead>
                
                <th>Image</th>
                <th>Item Name</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Action</th>

            </thead>
            <tbody>
                <?php
                $total=0;
                foreach ($_SESSION['cart'] as $key=>$value){
                    ?>
                <tr>
                   
                    <td><img src="assets/img/<?= $value['item_image'] ?>" height="100"></td>
                    <td><?= $value['item_name'] ?></td>
                    <td><?= $value['unit_price'] ?></td>
                    <td>
                        <form action="cart.php" method="get">
                            <input type="hidden" name="update_quantity_id" value="<?= $key ?>">
                            <input type="number" name="update_quantity" value="<?= $value['qty'] ?>">
                            <input type="submit" name="qty" value="update" onchange="form.submit()">
                        </form>
                    </td>
                    <td style="text-align: right">Rs.
                        <?php $amount=$value['unit_price']*$value['qty'];
                         $total+=$amount;
                          echo number_format($amount,2) ; ?>
                    </td>
                    <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>"
                            onclick="return confirm('remove item from cart?')" class="delete-btn"><i
                                class="fas fa-trash"></i>Remove</a></td>

                </tr>
                <!-- <?php  
                $grand_total += $sub_total;      
                    }
                
                ?> -->
                <tr class="table-bottom">
                    <td><a href="items.php" class="option-btn" style="margin-top:0;">Continue Shopping</a></td>
                    <td colspan="3">Grand Total</td>
                    <td><?php echo $grand_total; ?></td>
                    <td><a href="cart.php?delete_all=true"
                            onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"><i
                                class="fas fa-trash"></i>Delete All</a></td>
                </tr>

                <!-- <?php
                
                ?> -->
            </tbody>
            <!-- <tfoot>
                <tr>
                    <td></td>
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right"><?= number_format($total,2) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Discount(3%)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right"><?= number_format($total*0.03,2) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Net</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right"><?= number_format(($total-$total*0.03),2) ?></td>
                </tr>

            </tfoot> -->
        </table>

        <a href="checkout.php">Checkout</a>
        </body>

        </html>

        <!-- 
        <?php


// Initialize the cart session variable if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle removing an item from the cart
if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header('location:cart.php');
    exit(); // Ensure script execution stops after redirection
}

// Handle emptying the entire cart
if(isset($_GET['delete_all'])){
    unset($_SESSION['cart']);
    header('location:cart.php');
    exit(); // Ensure script execution stops after redirection
}

$total = 0; // Initialize total variable for grand total calculation
?>

        <html>

        <head>
            <title>Cart</title>
        </head>

        <body>
            <a href="cart.php?delete_all=true">Empty Cart</a>
            <table border="1" width="100%" style="border: 1px solid #055160">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
    foreach ($_SESSION['cart'] as $key => $value){
        ?>
                    <tr>
                        <td></td>
                        <td><?= $value['item_name'] ?></td>
                        <td><img src="<?= $value['item_image'] ?>" alt="Item Image" height="50"></td>
                        <td><?= $value['unit_price'] ?></td>
                        <td>
                            <form method="get" action="cart.php">
                                <input type="hidden" name="id" value="<?= $key ?>">
                                <input type="hidden" name="action" value="update_qty">
                                <input type="text" value="<?= $value['qty'] ?>" name="qty" onchange="form.submit()">
                                <select name="qty" onchange="form.submit()">
                                    <option value="">--</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </form>
                        </td>
                        <td style="text-align: right"><?php $amt=$value['unit_price']*$value['qty'];
             $total+=$amt; echo number_format($amt,2) ; ?></td>
                        <td>
                            <a href="cart.php?remove=<?= $key ?>&action=del">Remove</a>
                        </td>
                    </tr>
                    <?php
    }
    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">Grand Total</td>
                        <td style="text-align: right"><?= number_format($total,2) ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>

            <a href="checkout.php">Checkout</a>
        </body>

        </html> -->