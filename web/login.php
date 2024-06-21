<?php
session_start();

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
<main id="main">
  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact ">
    <div class="container">
      <div class="row">
        <div class="section-title ">
          <h2>Login</h2>
          <p class="text-center text-dark">Login</p>
        </div>
      </div>
    </div>
    <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                extract($_POST);

                $username = dataClean($username);

                $message = array();

                if (empty($username)) {
                    $message['username'] = "User Name should not be empty...!";
                }
                if (empty($password)) {
                    $message['password'] = "Password should not be empty...!";
                }
                
                if(empty($message)){
                    $db = dbConn();
                    $sql="SELECT * FROM users u INNER JOIN customers c ON c.UserId=u.UserId WHERE u.UserName='$username'";
                    $result=$db->query($sql);                    
                    
                    if($result->num_rows==1){
                       $row=$result->fetch_assoc();
                       
                       if(password_verify($password, $row['Password'])){
                           $_SESSION['USERID']=$row['UserId'];
                           $_SESSION['FIRSTNAME']=$row['FirstName'];
                           header("Location:dashboard.php");
                       }else{
                           $message['password'] = "Invalid User Name or Password...!";
                       }
                       
                       
                    }else{
                        $message['password'] = "Invalid User Name or Password...!";
                    }
                }
            }
            ?>
    <div class="row justify-content-center">

      <div class=" col-lg-8 mt-5 mt-lg-0 justify-content-center ">

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form "
          novalidate>


          <div class="form-group mt-3">
            <label for="name">User Name</label>
            <input type="text" class="form-control" name="username" id="Username" placeholder="Enter your User Name"
              required>
            <span class="text-danger"><?= @$message['username'] ?></span>
          </div>
          <div class="form-group mt-3">
            <label for="name">password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password"
              required>
            <span class="text-danger"><?= @$message['password'] ?></span>
          </div>

          <div class="my-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your message has been sent. Thank you!</div>
          </div>
          <div class="text-center"><button type="submit">Login</button></div>
        </form>

      </div>

    </div>

    </div>
  </section><!-- End Contact Section -->


</main>

<footer id="footer">
      <div class="footer-top">
          <div class="container">
              <div class="row">

                  <div class="col-lg-3 col-md-6">
                      <div class="footer-info">
                          <h3><span></span></h3>
                          <img src="assets/img/logo design.jpeg" alt="" class="img-fluid" width="100%"></a>
                          <p>
                              NO. 50/1 <br>
                              NIDHAS MAWATHA<br>
                              KEGALLE<br>
                              <strong>Phone:</strong> +94 771153923<br>
                              <strong>Email:</strong> superzonic@gmail.com<br>
                          </p>
                          <div class="social-links mt-3">
                              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                          </div>
                      </div>
                  </div>

                  <div class="col-lg-2 col-md-6 footer-links">
                      <h4>Useful Links</h4>
                      <ul>
                          <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                          <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                          <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                          <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                          <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                      </ul>
                  </div>

                  <div class="col-lg-3 col-md-6 footer-links">
                      <h4>Our Services</h4>
                      <ul>
                          <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                          <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                          <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                          <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                          <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                      </ul>
                  </div>

                  <div class="col-lg-4 col-md-6 footer-newsletter">
                      <h4>Our Newsletter</h4>
                      <p>
                          "Subscribe now for exclusive tech updates and deals!"</p>
                      <form action="" method="post">
                          <input type="email" name="email"><input type="submit" value="Subscribe">
                      </form>

                  </div>

              </div>
          </div>
      </div>

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
  <script src="https://cdn.jsdelivr.net/npm/fontawesome-free@1.0.4/js/all.min.js"></script>


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  </body>

  </html>