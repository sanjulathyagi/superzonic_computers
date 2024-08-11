<?php 

include 'header.php';
include '../function.php';

$total=0;
$noitems=0;
if(isset($_SESSION['cart'])) {
    $cart=$_SESSION['cart'];
    foreach($cart as $key=>$value) {
        $total+= $value['qty'] *$value['unit_price'];
        $noitems+= $value['qty'];
    }
}
 "<a href='cart.php'".$total . "[" . $noitems . "]" . "</a>";
 $_SESSION['noitems']= $noitems;  
?>
<style>
    .cart_count {
        background-color: red;
        color: white;
        border-radius: 50%;
        width: 20px;
        top: 12px;
        right: 20px;
        font-size: 12px;
        padding: 5px 10px;

    }
</style>
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="container">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="cart.php" style="margin-left:1150px !important;text-align:right;">
                            <span class="cart_count"><?=$noitems ?></span><i class="fa fa-shopping-cart"></i></a>
                        <a href="appointment.php" style="text-align:right;"><i class="fas fa-laptop-house"></i></a>
                        <a href="contact.php"><i class="fas fa-phone"></i></a>

                    </div>

                </div>

            </div>

        </div>
    </section><br>
    <!-- End Breadcrumbs -->
    <!-- item_stock.qty - item_stock.issued_qty as availableqty -->
    <?php   
                 $db = dbConn();
                $sql = "SELECT s.id, i.item_name, i.item_image, s.qty,
                s.qty, s.unit_price, c.category_name,m.model_name
                FROM item_stock s
                INNER JOIN items i
                ON (i.id = s.item_id)
                INNER JOIN item_category c
                ON (c.id = i.item_category)
                INNER JOIN models m
                ON (m.id = i.model_id)
                
                GROUP BY i.id, s.unit_price";
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
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT s.id, i.item_name, i.item_image, s.qty,
                        s.qty, s.unit_price, c.category_name,m.model_name
                        FROM item_stock s
                        INNER JOIN items i
                        ON (i.id = s.item_id)
                        INNER JOIN item_category c
                        ON (c.id = i.item_category)
                        INNER JOIN models m
                        ON (m.id = i.model_id)
                        
                        GROUP BY i.id, s.unit_price";
                        $result = $db->query($sql); 
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="col-md-3">
                            <div class="item-grid">
                                <div class="item-image card-img-top">
                                    <a href="">
                                        <img src="../uploads/<?=  $row['item_image'] ?>" alt="<?= $row['item_name'] ?>"
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
                                <div class="display: flex; gap:10px;">
                                    <form method="post" action="shopping_cart.php">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="operate" value="add_cart" class="btn btn-warning"
                                            style="width: 50px; height: 40px;font-size:15px !important;">
                                            <i class="fa fa-shopping-cart"></i>
                                        </button>

                                    </form><br>
                                    <form method="post" action="view.php">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <button type="submit" name="operate" value="view_cart" class="btn btn-dark"
                                            style="width: 50px; height: 40px;font-size:15px !important;">
                                            <i class="fa fa-search"></i>
                                        </button>

                                    </form>
                                </div>
                                <!-- store stock id inside hidden field -->

                                

                            </div>
                        </div><?php
                             }
                         } else {
                             echo 'No products found.';
                         }

                    ?>
                    <button type="submit">Compare Selected Products</button>
                    </form>
                    </div>
                </div>
                
        </div>


    </div>


    <?php
include 'footer.php';
?>