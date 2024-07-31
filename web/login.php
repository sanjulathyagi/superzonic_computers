<?php
ob_start();

include '../function.php';
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">


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
                    $message['username'] = "User Name should not be empty....!";
                }
                if (empty($password)) {
                    $message['password'] = "Password should not be empty....!";
                }
                if (empty($message)) {
                    $db = dbConn();
                    $sql = "SELECT * FROM  users u INNER JOIN customers c ON C.UserId = u.UserId WHERE u.Username ='$username'";
                    $result = $db->query($sql);

                    if($result->num_rows==1){
                        $row=$result->fetch_assoc();
                        if(password_verify($password, $row['Password'])){
                            $_SESSION['USERID']=$row['UserId'];
                            $_SESSION['FIRSTNAME']=$row['FirstName'];
                            header("Location:dashboard.php");

                        }else {
                            $message['password'] = "Invalid User Name or Password...!";
                        }
                    }else {
                        $message['password'] = "Invalid User Name or Password...!";
                    }
                }
            }
            ?>
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6 justify-content-center">
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form"
                        class="php-email-form" novalidate>
                        <div class="mt-3 form-group">
                            <label for="name">User Name</label>
                            <input type="text" class="form-control" name="username" id="Username"
                                placeholder="User Name" required>
                            <span class="text-danger"><?= @$message['username'] ?></span>
                        </div>
                        <div class="mt-3 form-group">
                            <label for="name">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="password"
                                required>
                            <span class="text-danger"><?= @$message['password'] ?></span>
                        </div>
                        <div class="text-center">
                            <button type="submit"> Login</button>
                        </div><br>
                        <p class="text-center">Don't have a account yet ?</p>
                        <p class="text-center "><a href="register.php">Register</a></p>
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
                            <div class="mt-3 social-links">
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
<?php
ob_end_flush();
?>