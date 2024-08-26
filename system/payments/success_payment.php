<?php
ob_start();
session_start();
include_once '../init.php';
include_once '../../function.php';

$link = "Supplier Management";
$breadcrumb_item = "Price Request";
$breadcrumb_item_active = "View Price Request";

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
                <a href="<?= SYS_URL ?>suppliers/price_request_list.php" class="mb-2 btn bg-warning btn-sm"><i class="fas fa-arrow-alt-circle-left"></i>
                Price Request List</a>
                    <h2 class="mb-4 text-warning">Email send Successfully</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="border card border-warning ">
                            <div class="card-body">
                                <h1 class="mb-4 text-center">Congratulations!</h1>
                                <h2 class="mb-4 text-center">Your Price Request Email has been successfully send with Token</h2>
                            

                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </section>
    </main>
    </body>
    <?php
$content= ob_get_clean();
include '../layouts.php';
?>