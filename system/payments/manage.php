<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Payment Management";
$breadcrumb_item = "payments ";
$breadcrumb_item_active = "Manage";
$alert=false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    

    if (!empty($id) && isset($status)) {
        $db =dbConn();
        $sql = "UPDATE payments SET payment_status='$payment_status' WHERE id='$id'";
        $result1 = $db->query($sql);
         if($result1){
            $alert=true;
         } else{
            $alert =false;
         }  
        }
    }

?>

<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>payments/add.php" class="mb-2 btn bg-warning btn-sm"><i class="fas fa-plus-circle"></i>
            New payment</a>
        
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Payment Details</h3>

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
                            <th>Payment Number</th>
                            <th>Order Number</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Payment Slip</th>
                            <th>Status</th>
                            <th>Change status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $payment_status = 0;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                        <tr>
                            <td><?= $row['payment_number'] ?></td>
                            <td ><?= $row['order_number'] ?></td>
                            <td><?= $row['amount'] ?></td>
                            <td><?= $row['date']?></td>
                            <td><img src= ../../uploads/payments/<?=  $row['payment_slip'] ?> alt="item_image" width="60px"></td>
                            <td><?= ($row['payment_status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Approve</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">pending</button>'; ?>
                          
                            <td>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                    <select name="payment_status" id="status" class="form-control-sm"
                                        onchange="this.form.submit()">
                                        <option value="1" <?= ($row['payment_status']==1)?'selected': '' ?>>Approve</option>
                                        <option value="0" <?= ($row['payment_status']==0) ? 'selected' : '' ?>>pending</option>
                                    </select>
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                </form>
                                

                            </td>

                            <td>
                                <a href="slip.php?payment_id=<?= $row['id']?>" class="btn btn-info btn-sm"> Download Payment Slip</a>
                               
                            </td>
                            <td>
                                <a href="sendslip.php?payment_id=<?= $row['id']?>" class="btn btn-info btn-sm"><i class="fas fa-edit"></i>Payment Slip</a>
                               
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
if($alert){
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        position: "top-middle",
        icon: "success",
        title: "status has been updated  ",
        showConfirmButton: false,
        timer: 1500
    });
</script>
<?php
}
?>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>

