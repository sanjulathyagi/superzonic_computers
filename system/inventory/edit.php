<?php
ob_start();
include_once '../init.php';

$link = "Inventory Management";
$breadcrumb_item = "Inventory ";
$breadcrumb_item_active = "Update";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    extract($_GET);
    $db = dbConn();
                $sql = "SELECT
    `item_stock`.`id`
    , `items`.`item_name`
    , `items`.`colour`
    , `item_category`.`category_name`
    , `item_stock`.`unit_price`
    , `items`.`item_image`
    , `item_stock`.`qty`
    , `item_stock`.`purchase_date`
    , `supplier`.`SupplierName`
    ,`items`.`status`
    ,`items`.`brand_id`
    ,`brands`.`brand`
FROM
    `items`
    INNER JOIN `item_stock` 
        ON (`items`.`id` = `item_stock`.`item_id`)
    INNER JOIN `item_category` 
        ON (`item_category`.`id` = `items`.`item_category`)
        INNER JOIN `brands` 
        ON (`brands`.`id` = `items`.`brand_id`)
    INNER JOIN `supplier` 
        ON (`supplier`.`id` = `item_stock`.`supplier_id`)";
                $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $item_name = $row['item_name'];
    $category_name = $row['category_name'];
    $unit_price = $row['unit_price'];
    $item_image = $row['item_image'];
    $colour = $row['colour'];
    $brand = $row['brand'];
    $qty= $row['qty'];
    $purchase_date = $row['purchase_date'];
    $SupplierName = $row['SupplierName'];
    
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $item_name = dataClean($item_name);
    $category_name = dataClean($category_name);
    $unit_price = dataClean($unit_price);
    $item_image= dataClean($item_image);
    $colour = dataClean($colour);
    $brand = dataClean( $brand);
    $qty = dataClean($qty);
    $purchase_date = dataClean($purchase_date);
    $SupplierName = dataClean($SupplierName);


   

    if (empty( $item_name)) {
        $message['item_name'] = "The ItemName should not be blank...!";
    }
    if (empty($category_name)) {
        $message['category_name'] = "The CategoryName should not be blank...!";
    }
    if (empty( $colour)) {
        $message['colour'] = "The colour should not be blank...!";
    }
    if (empty($unit_price)) {
        $message['unit_price'] = "The Unit_price Date should not be blank...!";
    }
    if (empty($item_image)) {
        $message['item_image'] = "The ItemImage should not be blank...!";
    }
    if (empty($Brand)) {
        $message['brand '] = "The brand should not be blank...!";
    }
    if (empty($qty)) {
        $message['qty'] = "The qty should not be blank...!";
    }
    if (empty($purchase_date)) {
        $message['purchase_date'] = "The purchase_date should not be blank...!";
    }
    if (empty($SupplierName)) {
        $message['SupplierName'] = "The SupplierName should not be blank...!";
    }
    
  
   
    if (empty($message)) {
              
        $db = dbConn();
        $sql = "UPDATE inventory i SET item_name='$item_name',category_name='$category_name',unit_price='$unit_price',colour='$colour',item_image='$item_image',brand='$brand',
        qty='$qty',purchase_date='$purchase_date',SupplierName='$SupplierName' WHERE item_id='$item_id'";
        $db->query($sql);

        header("Location:manage.php");
    }
}
?>
<div class="row">
    <div class="col-12">

        <div class="card card-primary">
            <div class="card-header bg-dark">
                <h3 class="card-title">Update Inventory </h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputItem_name">Item Name</label>
                                <input type="text" class="form-control" id="item_name" name="item_name"
                                    placeholder="Enter Item Name" value="<?= @$item_name ?>">
                                <span class="text-danger"><?= @$message['item_name'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputCategory Name">Category Name</label>
                                <input type="text" class="form-control" id="category_name" name="category_name"
                                    placeholder="Enter Category Name" value="<?= @$category_name ?>">
                                <span class="text-danger"><?= @$message['category_name'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputColour">Colour</label>
                                <input type="text" class="form-control" id="colour" name="colour"
                                    placeholder="Enter Colour" value="<?= @$colour ?>">
                                <span class="text-danger"><?= @$message['colour'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputUnit_price">Unit Price</label>
                                <input type="text" class="form-control" id="unit_price" name="unit_price"
                                    placeholder="Enter unit price" value="<?= @$unit_price ?>">
                                <span class="text-danger"><?= @$message['unit_price'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputItem_image">item_image</label>
                                <input type="text" class="form-control" id="item_image" name="item_image"
                                    placeholder="Enter item_image" value="<?= @$item_image ?>">
                                <span class="text-danger"><?= @$message['item_image'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputBrand ">Brand </label>
                                <input type="text" class="form-control" id="brand" name="brand "
                                    placeholder="Enter brand " value="<?= @$brand  ?>">
                                <span class="text-danger"><?= @$message['brand '] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputQty">Quantity</label>
                                <input type="text" class="form-control" id="qty" name="qty"
                                    placeholder="Enter qty" value="<?= @$qty ?>">
                                <span class="text-danger"><?= @$message['qty'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputPurchase_date">purchase_date </label>
                                <input type="text" class="form-control" id="purchase_date " name="purchase_date "
                                    placeholder="Enter purchase_date " value="<?= @$purchase_date  ?>">
                                <span class="text-danger"><?= @$message['purchase_date '] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputSupplierName">SupplierName</label>
                                <input type="text" class="form-control" id="SupplierName" name="SupplierName"
                                    placeholder="Enter SupplierName" value="<?= @$SupplierName ?>">
                                <span class="text-danger"><?= @$message['SupplierName'] ?></span>
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