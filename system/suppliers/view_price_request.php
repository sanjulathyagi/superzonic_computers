<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Price Request";
$breadcrumb_item_active = "View Price Request";

extract($_GET);

$db= dbConn ();
 $sql = "SELECT pi.quantity,i.item_name 
 FROM price_request_items pi 
 LEFT JOIN items i ON i.id=pi.item_id 
 WHERE pi.price_request_id = '$price_request_id'
 
";
$result = $db->query($sql);

?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>suppliers/price_request_list.php" class="mb-2 btn bg-dark btn-sm"><i
                class="fas fa-arrow-alt-circle-left"></i>
            View price request</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Order Item Details</h3>


            </div>
            <!-- /.card-header -->


            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>


                    </tr>
                </thead>
                <tbody>
                    <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                    
                    <tr>
                        <td><?= $row['item_name'] ?></td>
                        <td><?= $row['quantity'] ?></td>
                    </tr>

                    <?php
                                }
                            }
                            ?>
                </tbody>
            </table>


        </div>
        <!-- /.card-body -->
    </div>
    <a href="<?= SYS_URL?>suppliers/send_price_request.php?price_request_id=<?=$price_request_id ?>" class="btn btn-info btn-sm">Send Price Request</a>
    <!-- /.card -->
</div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>