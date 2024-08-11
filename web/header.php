<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$total=0;
$noitems=0;
if(isset($_SESSION['cart'])) {
    $cart=$_SESSION['cart'];
    foreach($cart as $key=>$value) {
        $total+= $value['qty'] *$value['unit_price'];
        $noitems+= $value['qty'];
    }
}
 "<a href='cart.php'".$total . "[" . $noitems . "]" . "</a>";
 $_SESSION['noitems']= $noitems;   
?>
<style>
    .cart_count{
        background-color:red;
        color:white;
        border-radius:50%;
        width:20px;
        top:12px;
        right:20px;
        font-size:12px;
        padding: 5px 10px;
        
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>SuperZonic</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/logo design.jpeg" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= WEB_URL ?>assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?= WEB_URL ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= WEB_URL ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= WEB_URL ?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?= WEB_URL ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?= WEB_URL ?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?= WEB_URL ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= WEB_URL ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= WEB_URL ?>assets/css/mystyle.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/fontawesome-free@1.0.4/css/all.min.css" rel="stylesheet">



</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top header-inner-pages" >
        <div class="container-fluid d-flex align-items-center justify-content-lg-between my-header-bg ">

            <!-- <h1 class="logo me-auto me-lg-0"><a href="index.html">SuperZonic<span><br/>Computers</span></a></h1> -->
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="<?= WEB_URL ?>index.html" class="logo me-auto me-lg-0 "><img src="<?= WEB_URL ?>assets/img/logo design.jpeg" alt=""
                    class="img-fluid" width="100%" ></a>

            <nav id="navbar" class="order-last navbar order-lg-0 ">
                <ul>
                    <li><a class="nav-link scrollto active" style="color:black !important;" href="<?= WEB_URL ?>index.php">Home</a></li>
                    <li><a class="nav-link scrollto"style="color:black !important;" href="<?= WEB_URL ?>item.php">Shop</a></li>
                    <li><a class="nav-link scrollto" style="color:black !important;"href="<?= WEB_URL ?>services.php">Services</a></li>
                    <li><a class="nav-link scrollto" style="color:black !important;"href="<?= WEB_URL ?>appointment.php">Appointments</a></li>
                    <li><a class="nav-link scrollto" style="color:black !important;"href="<?= WEB_URL ?>contact.php">Contacts</a></li>
                    <li><a href="<?= WEB_URL ?>account.php "style="color:black !important;"><i class="fas fa-user-alt"></i></a></li>
                    <li><a href="<?= WEB_URL ?>chat/index.php "style="color:black !important;"><i class="fas fa-comment-alt"></i></a></li>
                    <li><a href="<?= WEB_URL ?>cart.php "style="color:black !important;"><span class="cart_count"><?=$noitems ?></span><i class="fa fa-shopping-cart"></i></a></li>



                </ul>
            
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>

            <?php 
                if(isset($_SESSION['USERID'])){
                  ?>
            <a href="<?= WEB_URL ?>register.php" class="get-started-btn bg-dark scrollto" style="border-radius: 50px !important;margin-right:-240px">Welcome,
                <?= $_SESSION['FIRSTNAME'] ?></a>
            <a href="<?= WEB_URL ?>logout.php" class="get-started-btn bg-dark scrollto" style="border-radius: 50px !important;">Logout</a>
            <?php
                }else {
                ?>
            <a href="<?= WEB_URL ?>register.php" class="get-started-btn bg-dark register-btn scrollto"  style=" margin-right:-280px !important;">Register</a>
            <a href="<?= WEB_URL ?>login.php" class="get-started-btn bg-dark scrollto" style="border-radius: 50px !important;">Login</a>
            <?php
              	}
              	?>

        </div>
       
    </header><!-- End Header -->