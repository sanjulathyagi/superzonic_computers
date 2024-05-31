<?php 
include '../function.php';
session_start(); 
if(!isset($_SESSION['USERID'])){
    header("Location:login.php");
}

    // $total = 0;
    //     $no_items = 0;
    //     if (isset($_SESSION['cart'])) {
    //         foreach ($_SESSION['cart'] as $key => $value) {
    //             $total += $value['qty'] * $value['unit_price'];
    //             $noitmes += $value['qty'];
    //         }
    //     }
    //     "<a href='cart.php'>".$total . "[" . $no_items . "]"."</a>";
      
?>

<!DOCTYPE html>
<html lang="en">

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
                    <li><a class="nav-link scrollto" style="color:black !important;" href="item.php">Shop</a></li>
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
        <!-- ======= Breadcrumbs ======= -->
        <section class="breadcrumbs">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="container">
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
        <!-- item_stock.qty - item_stock.issued_qty as availableqty -->
        <?php   
                 $db = dbConn();
                $sql = "SELECT item_stock.id, items.item_name, items.item_image, item_stock.qty,
                item_stock.qty, item_stock.unit_price, item_category.category_name,models.model_name
                FROM item_stock
                INNER JOIN items 
                ON (items.id = item_stock.item_id)
                INNER JOIN item_category 
                ON (item_category.id = items.item_category)
                INNER JOIN models 
                ON (models.id = items.model_id)
                GROUP BY items.id, item_stock.unit_price";
                $result1 = $db->query($sql);
                ?>
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Categories</h3>
                            <ul class="list-group">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM item_category";
                                $result = $db->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                ?>
                                <li class="list-group-item"><a style="color:black;"
                                        href="item.php?id=<?= $row['id'] ?>"><?= $row['category_name'] ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h3 class="card-title">Brands</h3>
                            <ul class="list-group">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM brands";
                                $result2 = $db->query($sql);
                                while ($row = $result2->fetch_assoc()) {
                                ?>
                                <li class="list-group-item"><a style="color:black;"
                                        href="item.php?id=<?= $row['id'] ?>"><?= $row['brand'] ?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <?php
                        
                    while ($row = $result1->fetch_assoc()) {
                    ?>
                        <div class="col-md-3">
                            <div class="item-grid">
                                <div class="item-image card-img-top">
                                    <a href="">
                                        <img src="assets/img/<?= $row['item_image'] ?>" alt="<?= $row['item_name'] ?>"
                                            class="image" style="width: 200px; height: 200px;">
                                    </a>
                                </div>
                                <div class="item-content">
                                    <h5 style="width: 220px;"><b><?= $row['item_name'] ?></b></h5>
                                    <h6 style="width: 300px;"><?= $row['model_name'] ?></h6>

                                    <div class="price" style="width: 250px;"><b>Rs. <span
                                                class="price-value"><?= number_format($row['unit_price'], 2) ?></b></span>
                                    </div>
                                </div>
                                <!-- store stock id inside hidden field -->
                                <form method="post" action="shopping_cart.php" style="width: 210px;">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="operate" value="add_cart" class="btn btn-warning"
                                        style="width: 100px; height: 40px;font-size:15px !important;">
                                        <i class="fa fa-shopping-cart"></i>
                                    </button>

                                </form>
                                <br>

                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    </div>
                </div>
            </div>


        </div>

        <?php
include 'footer.php';
?>