<?php
ob_start();
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
    <header id="header" class="fixed-top header-inner-pages" >
        <div class="container-fluid d-flex align-items-center justify-content-lg-between my-header-bg ">

            <!-- <h1 class="logo me-auto me-lg-0"><a href="index.html">SuperZonic<span><br/>Computers</span></a></h1> -->
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="index.html" class="logo me-auto me-lg-0 "><img src="assets/img/logo design.jpeg" alt=""
                    class="img-fluid" width="100%" ></a>

            <nav id="navbar" class="navbar order-last order-lg-0 ">
                <ul>
                    <li><a class="nav-link scrollto active" style="color:black !important;" href="index.php">Home</a></li>
                    <li><a class="nav-link scrollto"style="color:black !important;" href="item.php">Shop</a></li>
                    <li><a class="nav-link scrollto" style="color:black !important;"href="services.php">Services</a></li>
                    <li><a class="nav-link scrollto" style="color:black !important;"href="appointment.php">Appointments</a></li>
                    <li><a class="nav-link scrollto" style="color:black !important;"href="contact.php">Contacts</a></li>



                </ul>
            
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
            <!-- <a href="cart.php" style="margin-right:-250px !important;"><i class="fa fa-shopping-cart"></i></a>
            <a href="appointment.php"  style="margin-right:-250px !important;"><i class="fas fa-laptop-house"></i></a>
            <a href="contact.php" ><i class="fas fa-phone"></i></a> -->

            <?php 
                if(isset($_SESSION['USERID'])){
                  ?>
            <a href="register.php" class="get-started-btn bg-dark scrollto" style="border-radius: 50px !important;margin-right:-320px">Welcome,
                <?= $_SESSION['FIRSTNAME'] ?></a>
            <a href="login.php" class="get-started-btn bg-dark  scrollto" style="border-radius: 50px !important;">Logout</a>
            <?php
                }else {
                ?>
            <a href="register.php" class="get-started-btn bg-dark register-btn scrollto">Register</a>
            <a href="login.php" class="get-started-btn bg-dark  scrollto" style="border-radius: 50px !important;">Login</a>
            <?php
              	}
              	?>

        </div>
       
    </header><!-- End Header -->