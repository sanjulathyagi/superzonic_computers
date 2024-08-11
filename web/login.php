<?php
ob_start();

session_start();

include '../config.php';
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
    <header id="header" class="fixed-top header-inner-pages">
        <div class="container-fluid d-flex align-items-center justify-content-lg-between my-header-bg ">

            <!-- <h1 class="logo me-auto me-lg-0"><a href="index.html">SuperZonic<span><br/>Computers</span></a></h1> -->
            <!-- Uncomment below if you prefer to use an image logo -->
            <a href="<?= WEB_URL ?>index.html" class="logo me-auto me-lg-0 "><img
                    src="<?= WEB_URL ?>assets/img/logo design.jpeg" alt="" class="img-fluid" width="100%"></a>

            <nav id="navbar" class="order-last navbar order-lg-0 ">
                <ul>
                    <li><a class="nav-link scrollto active" style="color:black !important;"
                            href="<?= WEB_URL ?>index.php">Home</a></li>
                    <li><a class="nav-link scrollto" style="color:black !important;"
                            href="<?= WEB_URL ?>item.php">Shop</a></li>
                    <li><a class="nav-link scrollto" style="color:black !important;"
                            href="<?= WEB_URL ?>services.php">Services</a></li>
                    <li><a class="nav-link scrollto" style="color:black !important;"
                            href="<?= WEB_URL ?>appointment.php">Appointments</a></li>
                    <li><a class="nav-link scrollto" style="color:black !important;"
                            href="<?= WEB_URL ?>contact.php">Contacts</a></li>
                    <li><a href="<?= WEB_URL ?>my_account.php " style="color:black !important;"><i
                                class="fas fa-user-alt"></i></a></li>
                    <li><a href="<?= WEB_URL ?>chat/index.php " style="color:black !important;"><i
                                class="fas fa-comment-alt"></i></a></li>
                    <li><a href="<?= WEB_URL ?>cart.php " style="color:black !important;"><span
                                class="cart_count"></span><i class="fa fa-shopping-cart"></i></a></li>



                </ul>

                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>

            <?php 
                if(isset($_SESSION['USERID'])){
                  ?>
            <a href="<?= WEB_URL ?>register.php" class="get-started-btn bg-dark scrollto"
                style="border-radius: 50px !important;margin-right:-240px">Welcome,
                <?= $_SESSION['FIRSTNAME'] ?></a>
            <a href="<?= WEB_URL ?>login.php" class="get-started-btn bg-dark scrollto"
                style="border-radius: 50px !important;">Logout</a>
            <?php
                }else {
                ?>
            <a href="<?= WEB_URL ?>register.php" class="get-started-btn bg-dark register-btn scrollto"
                style=" margin-right:-280px !important;">Register</a>
            <a href="<?= WEB_URL ?>login.php" class="get-started-btn bg-dark scrollto"
                style="border-radius: 50px !important;">Login</a>
            <?php
              	}
              	?>

        </div>

    </header><!-- End Header -->
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
                <div class="col-lg-6 col-md-6 justify-content-center bg-light">
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
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="password" required>
                            <span class="text-danger"><?= @$message['password'] ?></span>
                        </div>
                        <div class="text-center">
                            <button type="submit"> Login</button><br>
                            <a href="<?= WEB_URL ?>reset.php">Forget Password</a>
                        </div><br>
                        <p class="text-center">Don't have a account yet ?</p>
                        <p class="text-center "><a href="<?= WEB_URL ?>register.php">Register</a></p>
                    </form>
                </div>
            </div>

        </section><!-- End Contact Section -->


    </main>



</body>

</html>
<?php
include 'footer.php';
ob_end_flush();
?>