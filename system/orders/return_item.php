<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "View Items";

extract($_GET);
extract($_POST);

$db = dbConn();
$sql = "SELECT o.*,c.FirstName,c.LastName FROM orders o INNER JOIN customers c ON c.CustomerId=o.customer_id WHERE o.id='$order_id'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$order_status = $row['order_status'];



//first check the item issued or not
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "SELECT * FROM order_items_issue WHERE order_id='$order_id' AND item_id='$item_id'";
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $stock_id = $row['stock_id'];
    $unit_price = $row['unit_price'];
    if ($return_type <> "damaged") {
        $sql = "UPDATE `order_items_issue` SET issued_qty = COALESCE(issued_qty, 0) - $quantity_return WHERE stock_id = '$stock_id' AND `order_id`='$order_id' AND `item_id`='$item_id'";
        $db->query($sql);

        $sql = "UPDATE `order_items` SET issued_qty = COALESCE(issued_qty, 0) - $quantity_return WHERE stock_id = '$stock_id' AND `order_id`='$order_id' AND `item_id`='$item_id'";
        $db->query($sql);

        $sql = "UPDATE `item_stock` SET issued_qty = COALESCE(issued_qty, 0) - $quantity_return WHERE ID = '$stock_id'";
        $db->query($sql);
    }
    $sql = "INSERT INTO order_return_items(order_id, item_id, stock_id, unit_price, qty, return_date,return_type) 
                    VALUES ('$order_id', '$item_id', '$stock_id', '$unit_price', '$quantity_return', '$return_date','$return_type')";
    $db->query($sql);
}
?>
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header">
          
            <div class="p-0 card-body table-responsive">

            <div class="row">
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h4>Customer Details</h4>
                                <?= $row['FirstName'] ?> <?= $row['LastName'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h4>Billing Details</h4>
                                <?= $row['billing_name'] ?>
                                <br>
                                <?= $row['billing_address'] ?>
                                <br>
                                <?= $row['billing_phone'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <h4>Delivery Details</h4>
                                <?= $row['delivery_name'] ?>
                                <br>
                                <?= $row['delivery_address'] ?>
                                <br>
                                <?= $row['delivery_phone'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <h2>Handle Returns</h2>
                <input type="hidden" id="item_id" name="item_id" value="<?= $item_id ?>"><br><br>
                <input type="hidden" id="order_id" name="order_id" value="<?= $order_id ?>"><br><br>
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="quantity_return">Quantity:</label>
                                <input type="number" id="quantity_return" name="quantity_return" required><br><br>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="return_type">Return Type:</label>
                                <select id="return_type" name="return_type" required>
                                    <option value="color_change">Color Change</option>
                                    <option value="category_change">Category Change</option>
                                    <option value="brand_change">Brand Change</option>
                                    <option value="damaged">Damaged</option>
                                </select><br><br>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                            <label for="return_date">Return Date:</label>
                            <input type="date" id="return_date" name="return_date" required><br><br>
                            </div>
                        </div>

                    </div>

                </div>
        </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer ">

        <button type="submit" class="btn btn-warning"  value="Handle Returns">Submit</button>
    </div>
    </form>
</div>
</div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>