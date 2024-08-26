<?php 

include '../config.php';
include 'header.php';
include '../function.php';

 $_SESSION['noitems']= $noitems;  
?>

<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="container">

                </div>

            </div>

        </div>
    </section><br>
    <!-- End Breadcrumbs -->
    <!-- item_stock.qty - item_stock.issued_qty as availableqty -->
    <?php   
                $db = dbConn();
                $sql = "SELECT i.*, b.brand, m.model_name, ic.category_name,im.ImagePath,s.*,s.qty-s.issued_qty as ava_qty
                FROM items i 
                LEFT JOIN item_stock s ON s.item_id = i.id
                LEFT JOIN item_category ic ON ic.id = i.item_category 
                LEFT JOIN brands b ON b.id = i.brand_id 
                LEFT JOIN models m ON m.id = i.model_id 
                LEFT JOIN itemimages im ON im.ItemID = i.id 
                WHERE i.status=1
                 GROUP BY i.id;";
                $result1 = $db->query($sql);
                ?>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="card"  style="height:50%; !important">
                    <div class="card-body" style="height:200%; !important">
                        <!-- <h3 class="card-title">Categories</h3>
                        <ul class="list-group">
                            <?php
                            
                                $db = dbConn();
                                $sql = "SELECT * FROM item_category";
                                $result = $db->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    
                                ?>
                            <li class="list-group-item"><a style="color:black;"
                                    href="<?= WEB_URL ?>item.php?id=<?= $row['id'] ?>"><?= $row['category_name'] ?></a>
                            </li>
                            <?php
                                }
                                ?>
                        </ul> -->



                        <div><img src="<?=WEB_URL ?>assets/img/mac.jpg" alt="" width="50">
                        </div><br>
                        <div><img src="assets/img/LENOVO-LOGO.jpg" alt="" width="50">
                        </div><br>
                        <div><img src="assets/img/Asus-Logoo.png" alt="" width="50">
                        </div><br>
                        <div><img src="assets/img/hp-300x300-1.png" alt="" width="50">
                        </div><br>
                        <div><img src="assets/img/msi-as.png" alt="" width="50">
                        </div><br>
                        <div><img src="assets/img/Dell-300x300.png" alt="" width="50">
                        </div><br>
                        <div><img src="assets/img/OIP.jpg" alt="" width="50">
                        </div><br>
                        <!-- <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid" alt="">
                      </div> -->
                    </div>
                    <div>
                        <div class="swiper-pagination"></div>
                    </div>

                </div>
            </div>

            <div class="col-md-10">

                <div class="row">
                    <?php
                        
                    while ($row = $result1->fetch_assoc()) {
                        $ava_qty=$row['ava_qty'];
                    ?>
                    <div class="col-md-3">
                        <div class="item-grid">
                            <div class="item-image card-img-top">
                            
                                <a href=""><span class="badge bg-info"><?= $row['category_name'] ?></span>
                                    <img src="../uploads/<?=  $row['ImagePath'] ?>" alt="<?= $row['item_name'] ?>"
                                        class="image" style="width: 200px; height: 200px;">
                                </a>
                            </div><br>
                            <?php
                                if($ava_qty >0){
                                    echo '<span class= "badge bg-success ">In Stock</span>';
                                }else {
                                     echo '<span class= "badge bg-danger ">Out of Stock</span>';
                                }
                            ?>
                             <!-- Category Tag -->
                            
                             
                            <div class="item-content">
                                <h5 style="width: 220px;"><b><?= $row['item_name'] ?></b></h5>
                                <h6 style="width: 300px;"><?= $row['model_name'] ?></h6>

                                <div class="price" style="width: 250px;"><b>Rs. <span
                                            class="price-value"><?= number_format($row['unit_price'], 2) ?></b></span>
                                </div>
                            </div>

                            <div class="display: flex; gap:10px;">

                                <form method="post" action="shopping_cart.php">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="operate" value="add_cart" class="btn btn-warning"
                                        style="width: 150px; height: 40px;font-size:15px !important;">
                                        <i class="fa fa-shopping-cart"></i> Add to Cart
                                    </button>
                                </form>
                                <form method="post" action="view.php">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" name="operate" value="view_cart" class="btn btn-dark"
                                        style="width: 150px; height: 40px;font-size:15px !important;">
                                        <i class="fa fa-search"></i> View Item
                                    </button>

                                </form>
                                <!-- <form action="compare.php" method="post">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="checkbox" name="compare[]" value="<?= $row['id'] ?>" onchange="this.form.submit()">
                    Compare
                </form> -->




                            </div>

                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <div id="compareButton">
                    <!-- <button type="submit" class="btn btn-info btn-sm">
                        Compare
                    </button> -->
                </div>

            </div>



        </div>


    </div>

    <?php
include 'footer.php';
?>