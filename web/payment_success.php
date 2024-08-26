<?php

include '../config.php';
include 'header.php';
include '../function.php';


?>
<script>
    Swal.fire({
        position: "top-middle",
        icon: "success",
        title: "Your payment has been successfully placed",
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

                    </div>
                </div>
            </div>
        </div>

    </section>

    <main id="main">
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2 class="mb-4 text-warning">payment Placed Successfully</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="border card border-warning ">
                            <div class="card-body">
                                <h1 class="mb-4 text-center">Congratulations!</h1>
                                <h2 class="mb-4 text-center">Your payment number has been successfully Generated</h2>
                                <p class="mb-4 text-center">Your payment Number:
                                    <span><?= $_SESSION['payment_number'] ?></span></p>
                                    <a href="<?=WEB_URL ?>track.php" class="checkout-btn bg-dark btn-sm">Track your
                                    Order</a>
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