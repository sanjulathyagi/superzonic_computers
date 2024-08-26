<?php

include '../config.php';
include 'header.php';
include '../function.php';
$order_number = $_SESSION['order_number'];



?>
<script>
    Swal.fire({
        position: "top-middle",
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
                                <h2 class="mb-4 text-center">Your order has been successfully placed</h2>
                                <p class="mb-4 text-center">Your Order Number:
                                    <span><?= $_SESSION['order_number'] ?></span></p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card-body">
                            <div class="card-title">
                                <b>Please proceed to make the payment</b>
                            </div>

                            <form action="<?=WEB_URL ?>payment.php " method="post">
                                <input type="hidden" name="order_number" value="<?=$_SESSION['order_number']?>">
                               
                                <button type="submit" class="btn btn-warning btn-sm">Proceed to Payment</button>
                                <br><br>
                            </form>
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