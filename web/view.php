<?php
include '../config.php';
include 'header.php';
include '../function.php';
extract($_POST);
extract($_GET); 



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && $_POST['operate'] == 'view_cart') {
    $db= dbConn ();
    $sql = "SELECT i.*
    FROM items i
    WHERE i.id='$id'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
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
          $db = dbConn();
         $sql = "SELECT i.*, b.brand, m.model_name, ic.category_name,im.ImagePath,s.*,d.*
          FROM items i 
          INNER JOIN item_stock s ON s.item_id = i.id
          INNER JOIN item_category ic ON ic.id = i.item_category 
          INNER JOIN brands b ON b.id = i.brand_id 
          INNER JOIN models m ON m.id = i.model_id 
          INNER JOIN itemimages im ON im.ItemID = i.id
          LEFT JOIN item_descriptions d ON d.item_id=i.id
            WHERE i.id = '$id' LIMIT 1";
          $result = $db->query($sql);
    
                ?>

        <!-- Portfolio Details Section -->
        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                <?php
                // Check if there is a result from the query
                if ($row = $result->fetch_assoc()) {
                ?>
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <!-- Main Image Display -->
                        <div class="portfolio-details-slider swiper">
                            <img id="mainImage" src="../uploads/<?= htmlspecialchars($row['ImagePath']) ?>" alt="Main Image" width="600">
                        </div>

                        <div>
                            <?php
                            // Query to get all images related to the item
                            $counter = 0;
                            $sql = "SELECT ImagePath FROM itemimages WHERE ItemID = '$id'";
                            $imageResult = $db->query($sql);

                            // Display each image as a thumbnail
                            while ($imageRow = $imageResult->fetch_assoc()) {
                            ?>
                            <img class="thumbnail" src="../uploads/<?= htmlspecialchars($imageRow['ImagePath']) ?>" alt="Thumbnail">
                            <?php 
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="portfolio-info">
                            <h3>Item Details</h3>
                            <ul>
                                <!-- Display item details -->
                                <li><strong><?= htmlspecialchars($row['item_name']) ?></strong></li>
                                <li><strong>Serial No</strong>: <?= htmlspecialchars($row['serial_number']) ?></li>
                                <li><strong>Category</strong>: <?= htmlspecialchars($row['category_name']) ?></li>
                                <li><strong>Brand</strong>: <?= htmlspecialchars($row['brand']) ?></li>
                                <li><strong>Model</strong>: <?= htmlspecialchars($row['model_name']) ?></li>
                            </ul>
                            <!-- Display availability and quantity -->
                            <span class="badge bg-success">Available</span> - <b><?= htmlspecialchars($row['balanced_qty']) ?></b><br>
                        </div>

                        <div class="portfolio-description">
                            <h2>Item details</h2>
                            <ul>
                                <!-- Display warranty and delivery details -->
                                <li><?= htmlspecialchars($row['warranty_details']) ?></li>
                                <li><?= htmlspecialchars($row['delivery_details']) ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </section>

        <!-- Item Features Section -->
        <section>
            <?php
            // Query to get item features
            $sql1 = "SELECT f.item_features, ff.*
                     FROM item_features ff 
                     LEFT JOIN features f ON f.id = ff.feature_name 
                     WHERE ff.item_id = '$id'";
            $result2 = $db->query($sql1);
            ?>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                       <table>
                        <tr>
                            <thead>
                                <th>Features</th>
                                <th>Feature Details</th>
                            </thead>
                            <tbody>
                            <?php
                            // Loop through each feature and display it
                            while ($row = $result2->fetch_assoc()) {
                            ?>
                            <tr>
                                <td width="200px"><?= htmlspecialchars($row['item_features']) ?></td>
                                <td><?= htmlspecialchars($row['feature_value']) ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                            </tbody>
                        </tr>
                       </table>
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