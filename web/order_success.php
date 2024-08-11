<?php

include '../config.php';
include 'header.php';
include '../function.php';
$_SESSION['order_number']=$order_number;
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
                                <p class="mb-4 text-center">Your Order Number: <span><?= $_SESSION['order_number'] ?></span></p>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card-body">
                            <div class="card-title">
                                <b>Payment Slip Upload</b>
                            </div>
                            If your payment method is Cash on delivery,please upload your payment slip using below form.
                            <form action="<?=WEB_URL ?>payment_success.php " method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="payment-slip">Upload Payment Slip</label>
                                    <input type="file" class="form-control-file" id="payment_slip" name="payment_slip">
                                </div><br>
                                <input type="hidden" name="order_number" value="<?=$_SESSION['order_number']?>">
                                <button type="submit" class="btn btn-warning btn-sm"> Submit Payment Slip</button>
                                <br><br>
                                Bank : Commercial Bank<br>
                                        Branch : Kegalle<br>
                                        Account Name : Superzonic computer store<br>
                                        Account Number : 8019327459<br>
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