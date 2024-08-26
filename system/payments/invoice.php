<?php
ob_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Invoice ";
$breadcrumb_item_active = "Manage";
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>order/add_stock.php" class="btn bg-warning mb-2"><i class="fas fa-plus-circle"></i>
            New</a>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Invoice Details</h3>

               
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= " invoices.invoice_date BETWEEN '$from_date' AND '$to_date' AND";
                    }
                    
                    
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db= dbConn ();
                $sql = "SELECT iv.*,s.SupplierName
                FROM invoices iv
                INNER JOIN supplier s ON s.id=iv.supplier_id";
                $result = $db->query($sql);
                ?>

                <table class="table table-hover text-nowrap" id="myTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Purchase order_id</th>
                            <th>Invoice Number</th>
                            <th>Invoice Date</th>
                            <th>Total Amount</th>
                            <th>Supplier</th>
                            <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php
                        $status = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['purchase_order_id'] ?></td>
                            <td><?= $row['invoice_number'] ?></td>
                            <td><?= $row['invoice_date'] ?></td>
                            <td><?= $row['total_amount'] ?></td>
                            <td><?= $row['SupplierName'] ?></td>
                          
                            <td>
                               
                            <a href="<?= SYS_URL ?>suppliers/view_invoice.php?id=<?= $row['id'] ?>"
                                    class="btn btn-warning btn-sm"><i class="fas fa-eye"></i>View Invoice</a>

                            </td>
                            <td>
                            <a href="<?= SYS_URL ?>suppliers/process_payment.php?id=<?= $row['id'] ?>"
                            class="btn btn-warning btn-sm"><i class="fas fa-eye"></i>Process Payment</a>
                            </td>
                           

                            </td>
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

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>