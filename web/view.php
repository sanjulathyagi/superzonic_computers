<?php
include '../function.php';
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/fontawesome-free@1.0.4/css/all.min.css" rel="stylesheet">


</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top header-inner-pages">
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
            <a href="register.php" class="get-started-btn register-btn scrollto">Welcome,
                <?= $_SESSION['FIRSTNAME'] ?></a>
            <a href="login.php" class="get-started-btn bg-dark scrollto">Logout</a>
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
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Item Details</h2>

                </div>

            </div>
        </section><!-- End Breadcrumbs -->
        <?php
         $total = 0;
         $num_items = 0;
        if (isset($_SESSION['cart'])) {
            $cart=$_SESSION['cart'];
            foreach ($cart as $key => $value) {
                $total += $value['qty'] * $value['unit_price'];
                $num_items += $value['qty'];
            }
        }
         "<a href='cart.php'>" . $total . "[" . $num_items . "]" . "</a>";
        ?>

        <?php   
        $db = dbConn();
        $sql = "SELECT item_stock.id, items.item_name, items.item_image, item_stock.qty,
         item_stock.qty, item_stock.unit_price, item_category.category_name
            FROM item_stock
            INNER JOIN items 
            ON (items.id = item_stock.item_id)
            INNER JOIN item_category 
            ON (item_category.id = items.item_category)
            GROUP BY items.id, item_stock.unit_price";
        $result = $db->query($sql);
        ?>

        <!-- ======= Portfolio Details Section ======= -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>

                <div class="row gy-4">

                    <div class="col-lg-8">
                        <div class="portfolio-details-slider swiper">
                            <div class="swiper-wrapper align-items-center">

                                <div class="swiper-slide">
                                    <img src="assets/img/<?= $row['item_image'] ?>" alt="<?= $row['item_name'] ?>"
                                        class="image">
                                </div>


                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="portfolio-info">
                            <h3>Item Details</h3>
                            <ul>
                                <li><strong>Category</strong>: Web design</li>
                                <li><strong>Brand</strong>: ASU Company</li>
                                <li><strong>Model</strong>: 01 March, 2020</li>
                                <li><strong>Project URL</strong>: <a href="#">www.example.com</a></li>
                            </ul>
                        </div>
                        <div class="portfolio-description">
                            <h2> Item details</h2>
                            <p>
                                Autem ipsum nam porro corporis rerum. Quis eos dolorem eos itaque inventore commodi
                                labore quia quia. Exercitationem repudiandae officiis neque suscipit non officia eaque
                                itaque enim. Voluptatem officia accusantium nesciunt est omnis tempora consectetur
                                dignissimos. Sequi nulla at esse enim cum deserunt eius.
                            </p>
                        </div>
                    </div>

                </div>
                <?php
                    }
                    ?>
            </div>
        </section><!-- End Portfolio Details Section -->

    </main><!-- End #main -->
    <?php

include 'footer.php';
?>