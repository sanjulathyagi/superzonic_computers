<?php
session_start();
extract($_GET);
if($_SERVER['REQUEST_METHOD']=='GET' && @$action=='del'){
    $cart=$_SESSION['cart'];
    unset($cart[$id]);
    $_SESSION['cart']=$cart;
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SuperZonic</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://cdn.jsdelivr.net/npm/fontawesome-free@1.0.4/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/mystyle.css" rel="stylesheet">


</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container-fluid d-flex align-items-center justify-content-lg-between my-header-bg ">

            <!-- <h1 class="logo me-auto me-lg-0"><a href="index.html">SuperZonic<span><br/>Computers</span></a></h1> -->
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="index.html" class="logo me-auto me-lg-0 "><img src="assets/img/logo design.jpeg" alt=""
                    class="img-fluid" width="100%"></a>

            <nav id="navbar" class="navbar order-last order-lg-0 ">
                <ul>
                    <li><a class="nav-link scrollto active" style="color:black !important;" href="index.php">Home</a>
                    </li>
                    <li><a class="nav-link scrollto" style="color:black !important;" href="shop.php">Shop</a></li>
                    <li><a class="nav-link scrollto" style="color:black !important;" href="services.php">Services</a>
                    </li>
                    <li><a class="nav-link scrollto" style="color:black !important;"
                            href="appointment.php">Appointments</a></li>
                    <li><a class="nav-link scrollto" style="color:black !important;" href="contact.php">Contacts</a>
                    </li>





                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>

            </nav><!-- .navbar -->

            <?php 
    if(isset($_SESSION['USERID'])){
      ?>
            <a href="register.php" class="get-started-btn  bg-dark register-btn scrollto"
                style="border-radius: 50px !important;margin-left:-100px;">Welcome,
                <?= $_SESSION['FIRSTNAME'] ?></a>
            <a href="login.php" class="get-started-btn bg-dark scrollto"
                style="border-radius: 50px !important;">Logout</a>
            <?php
    }else {
    ?>
            <a href="register.php" class="get-started-btn bg-dark register-btn scrollto">Register</a>
            <a href="login.php" class="get-started-btn bg-dark  scrollto"
                style="border-radius: 50px !important;">Login</a>
            <?php
      }
      ?>


        </div>
    </header><!-- End Header -->
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
                            <thead >
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
                                <?php
                        $total = 0;
                        foreach ($_SESSION['cart'] as $key => $value) {
                        ?>
                                <tr>
                                    <td><?= $key ?></td>
                                    <td><img src="web/assets/img/<?= $row['item_image'] ?>"alt="Item Image" width="100%" height="100%"></td>
                                    <td><?= $value['item_name'] ?></td>
                                    <td><?= $value['unit_price'] ?></td>
                                    <td>
                                        <form method="get" action="cart.php">
                                            <input type="hidden" name="id" value="<?= $key ?>">
                                            <input type="hidden" name="action" value="update_qty">
                                            <input type="text" value="<?= $value['qty'] ?>" name="qty"
                                                onchange="form.submit()">
                                            <select name="qty" onchange="form.submit()">
                                                <option value="">--</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td><?= number_format($value['unit_price'] * $value['qty'], 2) ?></td>
                                    <td><a href="cart.php?id=<?= $key ?>&action=del" class="remove-item-btn bg-warning"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php
                            $total += $value['unit_price'] * $value['qty'];
                        }
                        ?>
                            </tbody>
                            <tfoot >
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

    </main>
</body>

</html>