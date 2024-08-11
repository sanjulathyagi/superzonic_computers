<?php 
session_start();
include '../config.php';
include 'header.php';
include '../function.php';
?>


<!-- ======= Header ======= -->

<main id="main">

  <!-- ======= Breadcrumbs ======= -->
  <section class="breadcrumbs">
    <div class="container">

      <div class="d-flex justify-content-between align-items-center">
        <h2>Contact Us</h2>
        <ol>
          <li><a href="index.html">Customer</a></li>
          <li>contact</li>
        </ol>
      </div>

    </div>
  </section>
  <section class="inner-page">
    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">
        <div class="row ">
          <div class="row col-lg-4 ">
            <div class="card">
              <div class="card-header">
                <h2>Contact information</h2>
              </div>
              <div class="card-body">
                <ul>
                  <li><i class="fas fa-map-marker-alt"></i> NO. 50/1 <br>
                    NIDHAS MAWATHA<br>
                    KEGALLE</li><br>
                  <li><i class="fas fa-phone"></i> +94 771153923</li><br>
                  <li><i class="fas fa-envelope"></i> <a href="superzonic@gmail.com"
                      class="text-dark">superzonic@gmail.com</a></li><br>
                </ul>
              </div>
            </div>

          </div>
          <div class="row col-lg-4">
            <div class="card ">
              <div class="card-header">
                <h2>Social Media</h2>
              </div>
              <div class="card-body">

                <i class="bx bxl-facebook"><a href="www.facebook.superzonic.com"
                    class="text-dark">Facebook</a></i><br><br>
                <i class="bx bxl-instagram"><a href="www.instagram.superzonic.com"
                    class="text-dark">Instagram</a></i><br><br>
                <i class="bx bxl-twitter"><a href="www.twitter.superzonic.com" class="text-dark">Twitter</a></i><br><br>
                <i class="bx bxl-linkedin"><a href="www.linkedin.superzonic.com"
                    class="text-dark">Linkedin</a></i><br><br>
                <i class="bx bxl-youtube"><a href="www.youtube.superzonic.com" class="text-dark">Youtube</a></i><br><br>

              </div>
            </div>

          </div>
          <div class="row col-lg-4">
            
            <img src="<?= WEB_URL ?>assets/img/logo design.jpeg" alt="" class="img-fluid" width="100%"></a>
            

          </div>
         
        </div>
      </div>
      </div>
    </section>
  </section>
  

</main>
<?php
include 'footer.php';
?>