<?php 

include '../config.php';
include 'header.php';
include '../function.php';


// if(!isset($_SESSION['USERID'])){
//     header("Location:login.php");
// }
// checkRole('F');

?>


<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2>Dashboard</h2>
      <ol>
        <li><a href="index.html">Customer</a></li>
        <li>dashboard</li>
      </ol>
    </div>
  </div>
</section>
<section class="inner-page">
  <div class="container">
    <section id="services" class="services">
      <div class="container" data-aos="fade-up">
        <div class="d-flex justify-content-between align-items-center">
          <div class="row">
            <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
              <div class="icon-box">
                <img src="<?= WEB_URL ?>assets/img/shopping-cart-home-appliances-electronics-vector-illus-illustration-114490947.webp" alt="laptop" class="first-img"
                  style="height:200px !important;width:200px !important;">
                
                <h5><a href="<?= WEB_URL ?>checkout.php">Cart and Checkout</a></h5>
                
              </div>
            </div>

            <div class="mt-4 col-lg-3 col-md-4 d-flex align-items-stretch mt-md-0" data-aos="zoom-in"
              data-aos-delay="200">
              <div class="icon-box">
                <img src="<?= WEB_URL ?>assets/img/SS1.png" alt="laptop" class="first-img"
                  style="height:200px !important;width:200px !important;">
                
                <h5><a href="<?= WEB_URL ?>check_availability.php">Appointment Bookings</a></h5>
                
              </div>
            </div>


            <div class="mt-4 col-lg-3 col-md-6 d-flex align-items-stretch mt-lg-0" data-aos="zoom-in"
              data-aos-delay="300">
              <div class="icon-box">
                <img src="<?= WEB_URL ?>assets/img/OIP.jpeg" alt="laptop" class="first-img"
                  style="height:200px !important;width:200px !important;">
                
                <h5><a href="<?= WEB_URL ?>account.php">My account History</a></h5>
                
              </div>
            </div>

            <div class="mt-4 col-lg-3 col-md-6 d-flex align-items-stretch mt-lg-0" data-aos="zoom-in"
              data-aos-delay="300">
              <div class="icon-box">
                
                <img src="<?= WEB_URL ?>assets/img/ecommerce-marketing-900.jpg" alt="laptop" class="first-img"
                  style="height:200px !important;width:200px !important;">
                <h5><a href="<?= WEB_URL ?>payments.php">Payment Details</a></h5>
                
              </div>
            </div>

          </div>

        </div>
    </section>
  </div>
</section>


<?php
  include 'footer.php';
  ?>