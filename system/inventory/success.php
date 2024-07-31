<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Brands Management";
$breadcrumb_item = "Brands";
$breadcrumb_item_active = "Manage";
?>
<div class="row">
    <div class="col-12">
        <a href="add.php" class="btn btn-warning mb-2"><i class="fas fa-plus-circle"></i>New</a>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Brands Details</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 100px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "New item  has been added",
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
                                <div class="col-lg-7 border border-3  border-success" data-aos="fade-up"
                                    data-aos-delay="200">
                                    <h1 class="text-center">Congratulations</h1>

                                    <h2 class="text-center">Your account has been successfully created</h2>

                                    <h1 class="text-center">Your serial Number is <b><?= $_SESSION['serial_number'] ?>
                                        </b> </h1>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';