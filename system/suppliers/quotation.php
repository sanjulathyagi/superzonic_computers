<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Quotation";
$breadcrumb_item_active = "Manage";
?>

<div class="row">
    <div class="col-12">
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Quotation details</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $db= dbConn ();
                $sql = "SELECT q.*,s.SupplierName
                FROM quotations q
                LEFT JOIN supplier s ON s.id=q.supplier_id";
                $result=$db->query($sql);

                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Price Request Id</th>
                            <th>Request Date</th>
                            <th>Quotation Date</th>
                            <th>Supplier</th>
                            <th>Total Amount</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $status=1;
                        if($result->num_rows> 0){
                            while ($row=$result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['price_request_id'] ?></td>
                            <td><?= $row['request_date'] ?></td>
                            <td><?= $row['quotation_date'] ?></td>
                            <td><?= $row['SupplierName'] ?></td>
                            <td><?= $row['total_amount'] ?></td>
                            <td><?= ($row['status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Approve</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">Pending</button>'; ?>
                            <td>
                            <a href="<?= SYS_URL ?>suppliers/create_purchase_order.php?quotation_id=<?= $row['id'] ?>&supplier_id=<?= $row['supplier_id'] ?>"
                            class="btn btn-warning btn-sm"><i class="fas fa-arrow-alt-circle-right"></i>Send Purchase Order</a>
                            </td>
                        </tr>

                        <?php
                            }
                            }?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<?php
$content= ob_get_clean();
include '../layouts.php';
?>