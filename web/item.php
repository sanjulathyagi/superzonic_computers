<?php 
include '../function.php';
session_start(); 
if(!isset($_SESSION['USERID'])){
    header("Location:login.php");
}

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
        <div class="container d-flex align-items-center justify-content-lg-between my-header-bg">

            <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo design.jpeg" alt=""
                    class="img-fluid" width="100%"></a>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav id="navbar" class="navbar order-last order-lg-0" >
                <ul>
                    <li><a class="nav-link scrollto active" href="index.php"><i class="fas fa-home"></i></a></li>
                    <li class="dropdown"><a href="#"><span>Laptops</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#"><img src="assets/img/hp-300x300-1.png" class="img-fluid" alt=""  width="35%"></a></li>
                            <li><a href="#"><img src="assets/img/Dell-300x300.png" class="img-fluid" alt=""  width="35%"> </a></li>
                            <li><a href="#"><img src="assets/img/LENOVO-LOGO.jpg" class="img-fluid" alt="" width="35%"></a></li></a></li>
                            <li><a href="#"><img src="assets/img/Asus-Logoo.png" class="img-fluid" alt=""  width="35%"></a></li>
                            <li><a href="#"><img src="assets/img/msi-as.png" class="img-fluid" alt=""  width="35%"></a></li>
                            <li><a href="#"><img src="assets/img/mac.jpg" class="img-fluid" alt=""  width="35%"></a></li>
                            <li><a href="#"><img src="assets/img/OIP.jpg" class="img-fluid" alt=""  width="35%"></a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>Desktop and servers</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Branded PC</a></li>
                            <li><a href="#">Desktops PC</a></li>
                            <li><a href="#">Gaming Pc</a></li>
                            <li><a href="#">workstations</a></li>
                            <li><a href="#">servers</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>Pc Components</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Processors</a></li>
                            <li><a href="#">Motherboards</a></li>
                            <li><a href="#">Memory</a></li>
                            <li><a href="#">Graphic Cards</a></li>
                            <li><a href="#">power supply</a></li>
                            
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>Peripherals</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">USB</a></li>
                            <li><a href="#">Speakers</a></li>
                            <li><a href="#">Mouse</a></li>
                            <li><a href="#">Headphones</a></a></li>
                            <li><a href="#">Microphones</a></a></li>
                            <li><a href="#">Webcam</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>Accessories</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#">Mouse Mat</a></li>
                            <li><a href="#">Cables</a></li>
                            <li><a href="#">LED Stripes</a></li>
                            <li><a href="#">Cooling Pad</a></li>
                            <li><a href="#">Fan</a></li>
                        </ul>
                    </li>
                    <li><a class="nav-link scrollto" href="#contact">Softwares</a></li>
                    <li><a class="nav-link scrollto " href="#contact"><i class="fas fa-phone-volume"></i></a></li>
                    <li><a class="nav-link scrollto" href="#services"><i class="fas fa-hands-helping"></i></a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
            <a href="register.php"
                class="get-started-btn register-btn scrollto">Welcome,<?= $_SESSION['FIRSTNAME'] ?></a>
            <a href="login.php" class="get-started-btn bg-dark scrollto">Logout</a>

        </div>
    </header><!-- End Header -->
    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section class="breadcrumbs">
            <div class="container">

                <!-- <div class="d-flex justify-content-between align-items-center">
                    <h2>Dashboard</h2>
                    <ol>
                        <li><a href="index.html">Item</a></li>
                        <li>dashboard</li>
                    </ol>
                </div> -->

            </div>
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
        </section><!-- End Breadcrumbs -->

        <section class="inner-page">
            <div class="container">
                <div class="row">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <div class="item-grid">
                            <div class="item-image">
                                <a href="">
                                    <img src="assets/img/<?= $row['item_image'] ?>" alt="<?= $row['item_name'] ?>"
                                        class="image1">
                                    <img src="assets/img/<?= $row['item_image'] ?>" alt="<?= $row['item_name'] ?>"
                                        class="image2">
                                </a>
                                <span class="item-trend-label">Trending</span>

                                <!-- <ul class="social">
                                    <li><a href="shopping_cart.php" name="operate" value="<?= $row['id'] ?>" data-tip="ADD to cart"><i
                                                class="fa fa-shopping-cart"></i></a></li>
                                    <li><a href="wishlist.php" data-tip="wishlist"><i class="fas fa-heart"></i></a></li>
                                </ul> -->
                            </div>
                            <form method="post" action="shopping_cart.php">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="operate" value="add_cart" class="bg-warning">Add to Cart</button>
                            </form>
                            <div class="item-content">
                                <h3 class="title"><a href=""><?= $row['item_name'] ?></a></h3>
                                <div class="price">Rs.<?= $row['unit_price'] ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>

    </main>
    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>superZonic</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/ -->
                Designed by A.A.S.T Athauda
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fontawesome-free@1.0.4/js/all.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>