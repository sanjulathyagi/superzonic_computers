<?php

include '../config.php';
include 'header.php';
include '../function.php';
?>
<script>
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "Your registration has been saved",
        showConfirmButton: false,
        timer: 1500
    });
</script>
<main id="main">
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2 class="text-success">SUCCESS</h2>

            </div>
            <div class="row justify-content-center">
                <div class="col-lg-7 border border-3  border-success" data-aos="fade-up" data-aos-delay="200">
                    <h1 class="text-center">Congratulations</h1>

                    <h2 class="text-center">Your account has been successfully created</h2>

                    <h1 class="text-center">Your Registration Number is <b><?= $_SESSION['RNO'] ?> </b> </h1>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include 'footer.php';
?>