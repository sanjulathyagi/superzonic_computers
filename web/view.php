<?php
include '../function.php';
include 'header.php';
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == "POST" && $operate == 'view_cart') {
    $db= dbConn ();
    $sql = "SELECT i.*
    FROM items i
    $where i.id='$id'";
    $result = $db->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<style>
    .thumbnail {
        cursor: pointer;
        width: 100px;
        height: 100px;
        object-fit: cover;
    }
</style>

<body>

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <section id="breadcrumbs" class="breadcrumbs">
            <div class="container">

                <div class="d-flex justify-content-between align-items-center">
                    <h2>Item Details</h2>

                </div>

            </div>
        </section><!-- End Breadcrumbs -->
        <?php
         $total = 0;
         $num_items = 0;
        if (isset($_SESSION['cart'])) {
            $cart=$_SESSION['cart'];
            foreach ($cart as $key => $value) {
                $total += $value['qty'] * $value['unit_price'];
                $num_items += $value['qty'];
            }
        }
         "<a href='cart.php'>" . $total . "[" . $num_items . "]" . "</a>";
        ?>

        <?php  
          $db= dbConn ();
                $sql = "SELECT i.*, b.brand,m.model_name,ic.category_name
                FROM items i
                INNER JOIN item_category ic
                    ON (ic.id=i.item_category)
                INNER JOIN brands b
                    ON (b.id=i.brand_id)
                INNER JOIN models m
                    ON (m.id = i.model_id) ";
             
                $result1 = $db->query($sql);
                ?>


        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-8">
                        <div class="portfolio-details-slider swiper">
                            <img id="mainImage" src="assets/img/portfolio/portfolio-details-1.jpg" alt="Main Image"
                                width="600">
                        </div>

                        <div>
                            <img class="thumbnail" src="assets/img/portfolio/portfolio-1.jpg" alt="Thumbnail 1"
                                data-full="assets/img/portfolio/portfolio-details-1.jpg">
                            <img class="thumbnail" src="assets/img/portfolio/portfolio-2.jpg" alt="Thumbnail 2"
                                data-full="assets/img/portfolio/portfolio-details-2.jpg">
                            <img class="thumbnail" src="assets/img/portfolio/portfolio-3.jpg" alt="Thumbnail 3"
                                data-full="assets/img/portfolio/portfolio-details-3.jpg">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="portfolio-info">
                            <h3>Item Details</h3>
                            <ul>
                                <li><strong><?= $row['item_name'] ?></strong></li>
                                <li><strong>Serial No:</strong>: <?= $row['serial_number'] ?></li>
                                <li><strong>Category</strong>: <?= $row['category_name'] ?></li>
                                <li><strong>Brand</strong>: <?= $row['brand']?></li>
                                <li><strong>Model</strong>: <?= $row['model_name']?></li>

                            </ul>
                        </div>
                        <div class="portfolio-description">
                            <h2> Item details</h2>
                            <p>
                                Autem ipsum nam porro corporis rerum. Quis eos dolorem eos itaque inventore commodi
                                labore quia quia. Exercitationem repudiandae officiis neque suscipit non officia eaque
                                itaque enim. Voluptatem officia accusantium nesciunt est omnis tempora consectetur
                                dignissimos. Sequi nulla at esse enim cum deserunt eius.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main><!-- End #main -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const thumbnails = document.querySelectorAll('.thumbnail');
            const mainImage = document.getElementById('mainImage');

            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function () {
                    const newSrc = this.getAttribute('data-full');
                    mainImage.setAttribute('src', newSrc);
                });
            });
        });
    </script>
    <?php

include 'footer.php';
?>