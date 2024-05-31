<?php
session_start();
include 'header.php';
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
                <h2 class="text-warning fw-bold mb-4">Your account has been successfully created</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border border-warning rounded-3 shadow">
                        <div class="card-body">
                            <h1 class="text-center mb-4">Congratulations!</h1>
                            <h2 class="text-center mb-4">Your account has been successfully created</h2>
                            <p class="text-center mb-4">Your Order Number: <span class="fw-bold"><?= $_SESSION['RNO'] ?>
                                </span></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
include 'footer.php';
?>