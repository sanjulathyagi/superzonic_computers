<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Brands Management";
$breadcrumb_item = "Brands";
$breadcrumb_item_active = "Add";


//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $brand = dataClean($brand);
    $item_name = dataClean($item_name);
    $item_quantity = dataClean($item_quantity);
    
    $message = array();
    if (empty($brand)) {
        $message['brand'] = "The brand should not be blank...!";
    }
    if (empty($item_name)) {
        $message['item_name'] = "The item name should not be blank...!";
    }
    if (empty($item_quantity)) {
        $message['item_quantity'] = "The item quantity should not be blank...!";
    }
    
    if (!empty($brand)) {
        $db = dbConn();
        $sql = "SELECT * FROM brands WHERE brand='$brand'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['brand'] = "This brand already exist...!";
        }
    }
}
?>
<div class="row">
    <div class="col-12">
    <a href="<?= SYS_URL ?>brands/manage.php" class="btn btn-warning mb-2"><i class="fas fa-plus-circle"></i>view</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New brand</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">

                    <div class="form-group">
                        <label for="inputBrand">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand"
                            placeholder="Enter Brand" value="<?= @$brand ?>">
                        <span class="text-danger"><?= @$message['brand'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="inputItem_name">Item Name</label>
                        <input type="text" class="form-control" id="item_name" name="item_name"
                            placeholder="Enter item name" value="<?= @$item_name ?>">
                        <span class="text-danger"><?= @$message['item_name'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="inputItem_quantity">Item Quantity</label>
                        <input type="text" class="form-control" id="item_quantity" name="item_quantity"
                            placeholder="Enter item quantity" value="<?= @$item_quantity ?>">
                        <span class="text-danger"><?= @$message['item_quantity'] ?></span>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">Submit</button>
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