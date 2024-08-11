<?php 

include '../config.php';
include 'header.php';
include '../function.php';


?>
<!-- ======= Services Section ======= -->
<section class="breadcrumbs">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Services</h2>
            <ol>
                <li><a href="index.html">customer</a></li>
                <li>Services</li>
            </ol>
        </div>
    </div>
</section>
<section id="services" class="services">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <p>Check our Services</p>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="row">
                <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                    <div class="icon-box">
                        <img src="<?= WEB_URL ?>assets/img/download image/OIP.jpg" alt="laptop" class="first-img"
                            style="height:90px !important;width:90px !important;">
                        <!-- <div class="icon"><i class="bx bxl-dribbble"></i></div> -->
                        <h4><a href="">Home delivery</a></h4>
                        <p>To further facilitate your access to your needs, we offer to deliver to meet your
                            requirements straight to where you live within Sri Lankan Borders. We assure you that
                        </p>
                    </div>
                </div>

                <div class="mt-4 col-lg-3 col-md-4 d-flex align-items-stretch mt-md-0" data-aos="zoom-in"
                    data-aos-delay="200">
                    <div class="icon-box">
                        <img src="<?= WEB_URL ?>assets/img/Aboutus_laptop.jpg" alt="laptop" class="first-img"
                            style="height:90px !important;width:90px !important;">
                        <!-- <div class="icon"><i class="bx bx-file"></i></div> -->
                        <h4><a href="">Laptop Repairing</a></h4>
                        <p>Our repair services are the cornerstone of our commitment to customer satisfaction. With a
                            team of skilled technicians and a dedication to excellence, we aim to swiftly address any
                            issues with your products.</p>
                    </div>
                </div>


                <div class="mt-4 col-lg-3 col-md-6 d-flex align-items-stretch mt-lg-0" data-aos="zoom-in"
                    data-aos-delay="300">
                    <div class="icon-box">
                        <img src="<?= WEB_URL ?>assets/img/Aboutus_onsite.jpg" alt="laptop" class="first-img"
                            style="height:90px !important;width:90px !important;">
                        <!-- <div class="icon"><i class="bx bx-tachometer"></i></div> -->
                        <h4><a href="">warranty assured</a></h4>
                        <p>In case of faulty products, we have an upstanding warranty and claim procedures to make
                            sure that your requirements are met in minimum time loss as possible. </p>
                    </div>
                </div>

                <div class="mt-4 col-lg-3 col-md-6 d-flex align-items-stretch mt-lg-0" data-aos="zoom-in"
                    data-aos-delay="300">
                    <div class="icon-box">
                        <!-- <div class="icon"><i class="bx bx-tachometer"></i></div> -->
                        <img src="<?= WEB_URL ?>assets/img/Aboutus_network.jpg" alt="laptop" class="first-img"
                            style="height:90px !important;width:90px !important;">
                        <h4><a href="">Network Solutions</a></h4>
                        <p>Networking your PCs? Will do a good job weather
                            it is a new project or an existing network extensions we could handle it with cabling and
                            connecting.</p>
                    </div>
                </div>

            </div>

        </div>
</section><!-- End Services Section -->



</main>
<?php
  include 'footer.php';
  ?>

