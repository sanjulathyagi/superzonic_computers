<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Brands Management";
$breadcrumb_item = "Brands";
$breadcrumb_item_active = "Update";


if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    extract($_GET);
    $db = dbConn();
    $sql = "SELECT
    `items`.`id`
    ,`items`.`item_name`
    ,`brands`.`item_quantity`
    ,`items`.`brand_id`
    ,`brands`.`brand`
    ,`brands`.`status`
    FROM
    `items`
    INNER JOIN `brands` 
    ON (`brands`.`id` = `items`.`brand_id`)";
            

    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $brand = $row['brand'];
    $item_name = $row['item_name'];
    $item_quantity = $row['item_quantity'];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $brand = dataClean($brand);
    $item_name = dataClean($item_name);
    $item_quantity = dataClean($item_quantity);
   
   

    if (empty($brand)) {
        $message['brand'] = "The brand should not be blank...!";
    }
    if (empty($item_name)) {
        $message['item_name'] = "The item name should not be blank...!";
    }
    if (empty($item_quantity)) {
        $message['item_quantity'] = "The item quantity should not be blank...!";
    }
    
  
   
    if (empty($message)) {
              
        $db = dbConn();
        $sql = "UPDATE brands b SET brand='$brand',item_name='$item_name',item_quantity='$item_quantity'";
        $db->query($sql);

        $sql = "UPDATE items i SET item_name='$item_name' WHERE i.brand_id= b.id'";
        $db->query($sql);

        header("Location:manage.php");
    }
}
?>
<div class="row">
    <div class="col-12">

        <div class="card card-primary">
            <div class="card-header bg-dark">
                <h3 class="card-title">Update User</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="inputBrand">Brand</label>
                                <input type="text" class="form-control" id="brand" name="brand"
                                    placeholder="Enter Brand" value="<?= @$brand ?>">
                                <span class="text-danger"><?= @$message['brand'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="inputItem_name">Item Name</label>
                                <input type="text" class="form-control" id="item_name" name="item_name"
                                    placeholder="Enter item name" value="<?= @$item_name ?>">
                                <span class="text-danger"><?= @$message['item_name'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="inputItem_quantity">Item Quantity</label>
                                <input type="text" class="form-control" id="item_quantity" name="item_quantity"
                                    placeholder="Enter item quantity" value="<?= @$item_quantity ?>">
                                <span class="text-danger"><?= @$message['item_quantity'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer ">
                    <input type="hidden" name="UserId" value="<?= $UserId ?>">
                    <button type="submit" class="btn btn-warning ">Submit</button>
                </div>
            </form>

        </div>
        <!-- /.card -->
    </div>
</div>


<?php
$content = ob_get_clean();
include '../layouts.php';
?>