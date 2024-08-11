<?php 

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
  <div class="container">
    <div class="p-5 bg-light rounded">
      <div class="row g-4">
        <div class="col-12">
          <div class="text-center mx-auto" style="max-width: 700px;">
            <h1 class="text-dark">Get In Touch With Us</h1>
            <h3 class="mb-4 text-warning">Let Us Help You</h3>
          </div>
        </div>

        <div class="col-lg-7">
          <form action="" class="">
            <input type="text" class="w-100 form-control border-0 py-3 mb-4" placeholder="Your Name">
            <input type="email" class="w-100 form-control border-0 py-3 mb-4" placeholder="Enter Your Email">
            <textarea class="w-100 form-control border-0 mb-4" rows="5" cols="10" placeholder="Your Message"></textarea>
            <button class="btn form-control bg-warning text-dark "
              type="submit">Submit</button>
          </form>
        </div>
        <div class="col-lg-5">
          <div class="d-flex p-4 rounded mb-4 bg-white">
            <i class="fas fa-map-marker-alt fa-2x text-warning me-4"></i>
            <div>
              <h4>Address</h4>
              <p class="mb-2">NO. 50/1 <br>
                              NIDHAS MAWATHA<br>
                              KEGALLE</p>
            </div>
          </div>
          <div class="d-flex p-4 rounded mb-4 bg-white">
            <i class="fas fa-envelope fa-2x text-warning me-4"></i>
            <div>
              <h4>Mail Us</h4>
              <p class="mb-2">superzonic@gmail.com</p>
            </div>
          </div>
          <div class="d-flex p-4 rounded bg-white">
            <i class="fa fa-phone-alt fa-2x text-warning me-4"></i>
            <div>
              <h4>Telephone</h4>
              <p class="mb-2">+94 771153923</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>




</main>
<?php
include 'footer.php';
?>