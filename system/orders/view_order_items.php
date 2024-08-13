<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Order Management";
$breadcrumb_item = "Order";
$breadcrumb_item_active = "View Items";

extract($_GET);

$db = dbConn();
$sql = "SELECT o.*,c.FirstName,c.LastName FROM orders o INNER JOIN customers c ON c.CustomerId=o.customer_id WHERE o.id='$order_id'";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$order_status = $row['order_status'];
?> 
<div class="row">
    <div class="col-12">
    <a href="<?= SYS_URL ?>orders/manage.php" class="mb-2 btn bg-dark btn-sm"><i class="fas fa-arrow-alt-circle-left"></i>
    View Orders</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order Item Details</h3>

                
            </div>
            <!-- /.card-header -->
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


                <?php
                $db = dbConn();
                 $sql = "SELECT 
    o.order_id,
    o.item_id,
    o.unit_price,
    o.qty,
    i.item_name,
    o.issued_qty,
    (COALESCE(stock_totals.total_qty, 0) - COALESCE(stock_totals.total_issued_qty, 0)) AS balance_qty
FROM 
    order_items o 
INNER JOIN 
    items i ON i.id = o.item_id 
LEFT JOIN 
    (
        SELECT 
            item_id,
            unit_price,
            SUM(qty) AS total_qty, 
            SUM(issued_qty) AS total_issued_qty 
        FROM 
            item_stock 
        GROUP BY 
            item_id,unit_price
    ) AS stock_totals ON stock_totals.item_id = o.item_id and  stock_totals.unit_price=o.unit_price
WHERE 
    o.order_id = '$order_id'
GROUP BY 
    o.order_id, o.item_id, o.unit_price;
";
                $result = $db->query($sql);
                ?>
                <form action="../inventory/issue.php" method="post">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Unit Price</th>
                                <th>Ordered Qty</th>
                                <th>Balance Qty</th>
                                <th>Issued Qty</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?= $row['item_name'] ?></td>
                                        <td><?= $row['unit_price'] ?></td>
                                        <td><?= $row['qty'] ?></td>
                                        <td><?= $row['balance_qty'] ?></td>
                                        <td>
                                            <?php if ($order_status == '1') {
                                                ?>
                                                <?= $row['issued_qty']; ?>
                                                <a href="return_item.php?item_id=<?= $row['item_id'] ?>&order_id=<?= $row['order_id'] ?>">Return Item</a>
                                                <?php } else {
                                                ?>
                                                <input type="hidden" name="items[]" value="<?= $row['item_id'] ?>">
                                                <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                                <input type="hidden" name="prices[]" value="<?= $row['unit_price'] ?>">                                           
                                                <input type="text" name="issued_qty[]" max="<?= $row['balance_qty'] ?>">
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Issue</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>

