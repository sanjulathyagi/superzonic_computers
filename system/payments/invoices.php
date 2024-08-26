<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Payment Management";
$breadcrumb_item = "invoices ";
$breadcrumb_item_active = "Manage";



?>

<div class="row">
    <div class="col-12">
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Invoice Details</h3>

            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php

                $db= dbConn ();
                $sql = "SELECT p.*
                FROM payments p
                 ";
                $result = $db->query($sql);
                ?>

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Invoice Date</th>
                            <th>Amount</th>
                            <th>Action</th>

                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <tr>
                            <td ><?= $row['invoice_number'] ?></td>
                            <td><?= $row['date'] ?></td>
                            <td><?= $row['amount']?></td>
                            <td><a href="<?= SYS_URL ?>payments/view.php?order_id=<?= $row['id'] ?>"
                            class="btn btn-info btn-sm" style="width: 90px;"><i class="fas fa-eye"></i> view</a>
                          
                            
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
        <!-- /.card -->
    </div>
</div>

<?php
$content = ob_get_clean();
include '../layouts.php';
?>

