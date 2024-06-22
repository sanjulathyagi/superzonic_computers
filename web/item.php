<?php 
include 'header.php';
include '../function.php';
session_start(); 


   
?>
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="cart.php" style="margin-left:1150px !important;text-align:right;"><i
                                class="fa fa-shopping-cart"></i></a>
                        <a href="appointment.php" style="text-align:right;"><i class="fas fa-laptop-house"></i></a>
                        <a href="contact.php"><i class="fas fa-phone"></i></a>

                    </div>

                </div>

            </div>

        </div>
    </section><br><!-- End Breadcrumbs -->
    <!-- item_stock.qty - item_stock.issued_qty as availableqty -->
    <?php   
                 $db = dbConn();
                $sql = "SELECT item_stock.id, items.item_name, items.item_image, item_stock.qty,
                item_stock.qty, item_stock.unit_price, item_category.category_name,models.model_name
                FROM item_stock
                INNER JOIN items 
                ON (items.id = item_stock.item_id)
                INNER JOIN item_category 
                ON (item_category.id = items.item_category)
                INNER JOIN models 
                ON (models.id = items.model_id)
                GROUP BY items.id, item_stock.unit_price";
                $result1 = $db->query($sql);
                ?>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Categories</h3>
                        <ul class="list-group">
                            <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM item_category";
                                $result = $db->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                ?>
                            <li class="list-group-item"><a style="color:black;"
                                    href="item.php?id=<?= $row['id'] ?>"><?= $row['category_name'] ?></a></li>
                            <?php
                                }
                                ?>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Brands</h3>
                        <ul class="list-group">
                            <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM brands";
                                $result2 = $db->query($sql);
                                while ($row = $result2->fetch_assoc()) {
                                ?>
                            <li class="list-group-item"><a style="color:black;"
                                    href="item.php?id=<?= $row['id'] ?>"><?= $row['brand'] ?></a></li>
                            <?php
                                }
                                ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <?php
                        
                    while ($row = $result1->fetch_assoc()) {
                    ?>
                    <div class="col-md-3">
                        <div class="item-grid">
                            <div class="item-image card-img-top">
                                <a href="">
                                    <img src="assets/img/<?= $row['item_image'] ?>" alt="<?= $row['item_name'] ?>"
                                        class="image" style="width: 200px; height: 200px;">
                                </a>
                            </div>
                            <div class="item-content">
                                <h5 style="width: 220px;"><b><?= $row['item_name'] ?></b></h5>
                                <h6 style="width: 300px;"><?= $row['model_name'] ?></h6>

                                <div class="price" style="width: 250px;"><b>Rs. <span
                                            class="price-value"><?= number_format($row['unit_price'], 2) ?></b></span>
                                </div>
                            </div>
                            <!-- store stock id inside hidden field -->
                            <form method="post" action="shopping_cart.php" style="width: 210px;">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="operate" value="add_cart" class="btn btn-warning"
                                    style="width: 100px; height: 40px;font-size:15px !important;">
                                    <i class="fa fa-shopping-cart"></i>
                                </button>

                            </form>
                            <br>

                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>


    </div>

    <?php
include 'footer.php';
?>