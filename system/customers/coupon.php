<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Customer Management";
$breadcrumb_item = "Customer";
$breadcrumb_item_active = "coupon";
$limit=10;
$alert=false;
?>
<?php
                                
                                
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
extract($_POST);
                                    
if (!empty($coupon_id) && isset($status)) {
    $db =dbConn();
    $sql = "UPDATE coupons SET status='$status' WHERE Coupon_id='$coupon_id'";
    $result1 = $db->query($sql);
    if($result1){
        $alert=true;
   } else{
        $alert =false;
        }
    }    }
                                
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>customers/add_coupon.php" class="mb-2 btn bg-warning btn-sm"><i class="fas fa-plus-circle"></i>
            Add New Coupon</a>
       

        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
           
            
            <input type="text" class="btn-sm btn light border-dark" name="FirstName"  placeholder="Enter Customer Name" name="Name">

            <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Coupon details</h3>


            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">

                <?php
                
                $where = null;
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    extract($_POST);
                    if(!empty($FirstName)){
                        $where.=" FirstName='$FirstName' AND";
                    }
                    
                    
                    if(!empty($where)){
                        $where= substr($where, 0,-3);
                        $where=" WHERE $where";
                    }
                }
                $db= dbConn ();
                $sql = "SELECT c.*,d.*,cc.*
                FROM coupons c
                INNER jOIN customers cc
                ON cc.CustomerId = c.customer_id
                LEFT JOIN discount_criteria d
                ON d.id = c.discount_criteria_id ";
                $result=$db->query($sql);

                ?>


                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr><th>Id</th>
                            <th>Customer</th>
                            <th>Coupon_code</th>
                            <th>Discount (%)</th>
                            <th>Start Date</th>
                            <th>Valid Period(years)</th>
                            <th>Used Count</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>Change status</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $status=1;
                        if($result->num_rows> 0){
                            while ($row=$result->fetch_assoc()) {
                        ?>
                        <tr>

                            <td><?= $row['customer_id'] ?></td>
                            <td><?= $row['FirstName'] ?>&nbsp;<?= $row['LastName'] ?></td>
                            <td><?= $row['coupon_code'] ?></td>
                            <td><?= $row['discount_percentage'] ?></td>
                            <td><?= $row['start_date'] ?></td>
                            <td><?= $row['valid_period'] ?></td>
                            <td><?= $row['used_count'] ?></td>
                            <td><?= ($row['status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Active</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">Expired</button>'; ?>
                            </td>
                            <td>
                                <div class="mb-1 dropdown no-arrow">
                                    <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="shadow dropdown-menu dropdown-menu-left animated--fade-in"
                                        aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                                        &nbsp;&nbsp;

                                        <a href="<?= SYS_URL ?>customers/view.php?CustomerId=<?= $row['CustomerId'] ?>"
                                            class="btn btn-info btn-sm"><i class="fas fa-eye"></i> view</a>
                                        <a href="<?= SYS_URL ?>customers/edit.php?CustomerId=<?= $row['CustomerId'] ?>"
                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>Edit</a>
                                        
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                    <select name="status" id="status" class="form-control-sm"
                                        onchange="this.form.submit()">
                                        <option value="1" <?= ($row['status']==1)?'selected': '' ?>>Active</option>
                                        <option value="0" <?= ($row['status']==0) ? 'selected' : '' ?>>Expired</option>
                                    </select>
                                    <input type="hidden" name="coupon_id" value="<?= $row['coupon_id'] ?>">
                                </form>

                            

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
$content= ob_get_clean();
include '../layouts.php';
?>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>