<?php
include 'header.php';
session_start();
if(!isset($_SESSION['USERID'])){
    header("Location:login.php");
}

?>
<main id="main">
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="shopping_cart.php" style="margin-left:1150px !important;text-align:right;"><i
                                class="fa fa-shopping-cart"></i></a>
                        <a href="appointment.php" style="text-align:right;"><i class="fas fa-laptop-house"></i></a>
                        <a href="contact.php"><i class="fas fa-phone"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <main id="main">
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2 class="text-warning mb-4">Order Placed Successfully</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border border-warning ">
                            <div class="card-body">
                                <h1 class="text-center mb-4">Congratulations!</h1>
                                <h2 class="text-center mb-4">Your order has been successfully placed</h2>
                                <p class="text-center mb-4">Your Order Number: <span><?= $_SESSION['order_number'] ?></span></p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    </body>



    <?php
include 'footer.php';
?>