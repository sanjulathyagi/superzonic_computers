<?php
include '../config.php';
include 'header.php';
include '../function.php';
extract($_POST);
extract($_GET); 

if ($_SERVER['REQUEST_METHOD'] == "POST" && $operate == 'view_cart') {
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
            WHERE i.id = '$id'";
          $result = $db->query($sql)
                ?>
 

        <section id="portfolio-details" class="portfolio-details">
            <div class="container">
                <?php
                        
                        foreach ($_SESSION['cart'] as $key => $value) {
                        ?>
                <div class="row gy-4">

                    <div class="col-lg-6">
                        <div class="portfolio-details-slider swiper">
                            <img id="mainImage" src="../uploads/<?=  $value['ImagePath'] ?>" alt="Main Image" width="600">
                        </div>

                        <div>
                            <?php
                            $counter=0;
                            $sql= "SELECT ImagePath From itemimages
                            WHERE ItemID = '$id'";
                            $imageResult = $db->query($sql);
                            while ($imageRow = $imageResult->fetch_assoc()) {
                                if($counter<3){
                                    ?>
                            <img class="thumbnail" src="../uploads/<?=  $imageRow['ImagePath']?>" alt="Thumbnail">

                            <?php 
                            
                            }
                        }
                    
                            ?>

                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="col-lg-6">
                        <?php
                         while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="portfolio-info">
                            <h3>Item Details</h3>

                            <ul>
                                <li><strong><?= $row['item_name'] ?></strong></li>
                                <li><strong>Serial No</strong>: <?= $row['serial_number'] ?></li>
                                <li><strong>Category</strong>: <?= $row['category_name'] ?></li>
                                <li><strong>Brand</strong>: <?= $row['brand']?></li>
                                <li><strong>Model</strong>: <?= $row['model_name']?></li>

                            </ul>
                            <span class="badge bg-success">Available</span> - <b><?= $row['balanced_qty']?></b><br>
                        </div>

                        <div class="portfolio-description">
                            <h2> Item details</h2>
                            <ul>
                                <li><?= $row['warranty_details']?></li>
                                <li><?= $row['delivery_details']?></li>
                            </ul>


                        </div>
                    </div>
                </div>
                <?php
                    }
                    ?>
            </div>
        </section>
        <section>
            <?php
            $db= dbConn ();
                $sql = "SELECT f.item_features,ff.*
                FROM item_features ff 
                LEFT JOIN features f ON f.id = ff.feature_name 
                WHERE ff.item_id = '$id' ";
                $result = $db->query($sql);
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
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                <td width="200px"><?= $row['item_features']?></td>
                                <td><?= $row['feature_value']?></td>
                                
                            </tbody>
                            <?php
                            }
                        }
                        ?>
                                </tr>
                                
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