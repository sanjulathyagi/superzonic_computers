<?php

include '../config.php';
include 'header.php';
include '../function.php';

?>
<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Your order has been successfully placed",
        showConfirmButton: false,
        timer: 1500
    });
</script>
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
                    <h2 class="mb-4 text-warning">Order Placed Successfully</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="border card border-warning ">
                            <div class="card-body">
                                <h1 class="mb-4 text-center">Congratulations!</h1>
                                <h2 class="mb-4 text-center">Your Appointment has been successfully placed</h2>
                                <p class="mb-4 text-center">Your Order Number: <span><?= $_SESSION['appointment_number'] ?></span></p>

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