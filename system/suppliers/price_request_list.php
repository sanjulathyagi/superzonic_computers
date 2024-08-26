<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Supplier";
$breadcrumb_item_active = "Manage";
$alert=false;

$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
unset($_SESSION['success_message']); // Clear the message after displaying it
extract($_GET);
?>

<div class="row">
    <div class="col-12">
    
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Price Request details</h3>

                
            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if (!empty($from_date) && !empty($to_date)) {
                        $where .= "RegDate BETWEEN '$from_date' AND '$to_date' AND";
                    }
                    
                    if(!empty($SupplierName)){
                        $where.="SupplierName='$SupplierName' AND";
                    }
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }

                $db= dbConn ();
                $sql = "SELECT p.*,s.SupplierName
                FROM price_request p
                INNER JOIN supplier s ON s.id=p.supplier_id
                $where";
    
                $result=$db->query($sql);

                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Supplier</th>
                            <th>Request Date</th>
                            <th>Delivery Date</th>
                            <th>Token</th>
                            

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $Status=1;
                        if($result->num_rows> 0){
                            while ($row=$result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['SupplierName'] ?></td>
                            <td><?= $row['request_date'] ?></td>
                            <td><?= $row['delivery_date'] ?></td>
                            <td><?= $row['token'] ?></td>
                            
                           
                            <td> <a href="<?= SYS_URL ?>suppliers/view_price_request.php?price_request_id=<?= $row['id'] ?>"
                            class="btn btn-warning btn-sm"><i class="fas fa-th-list"></i> View Price Request</a></td>

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
$content= ob_get_clean();
include '../layouts.php';
?>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>

