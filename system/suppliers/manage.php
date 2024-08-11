<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Supplier";
$breadcrumb_item_active = "Manage";
$alert=false;
?>

<div class="row">
    <div class="col-12">
    <a href="<?= SYS_URL ?>suppliers/add.php" class="mb-2 btn bg-warning btn-sm"><i class="fas fa-plus-circle"></i>
            Add New Supplier</a>
        <a href="<?= SYS_URL ?>suppliers/add_report.php" class="mb-2 btn bg-dark btn-sm"><i class="fas fa-th-list"></i>
            Supplier Details Report</a>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="text-align:right">
            <input type="date" class="btn-sm btn bg-secondary" name="from_date">
            <input type="date" class="btn-sm btn bg-secondary" name="to_date">
            <input type="text" class="btn-sm btn light border-dark" name="supplier_name"
                placeholder="Enter Supplier Name">
            <button type="submit" class="btn-sm btn bg-dark"><i class="fas fa-search"></i> Search</button>
        </form>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Supplier details</h3>

                
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
                $sql = "SELECT s.*
                FROM supplier s
                $where";
    
                $result=$db->query($sql);

                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Supplier Name</th>
                            <th>Email</th>
                            <th>Add.Line1</th>
                            <th>Add.Line2</th>
                            <th>city</th>
                            <th>TelNo</th>
                            <th>Register Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th>Change status</th>

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
                            <td><?= $row['Email'] ?></td>
                            <td><?= $row['Addressline1'] ?></td>
                            <td><?= $row['Addressline2'] ?></td>
                            <td><?= $row['Addressline3'] ?></td>
                            <td><?= $row['TelNo'] ?></td>
                            <td><?= $row['RegisterDate'] ?></td>
                            <td><?= ($row['Status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Active</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">Disable</button>'; ?></td>                    
                            <td>
                                <div class="mb-1 dropdown no-arrow">
                                    <a class="btn btn-sm btn-icon-only text-dark" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="shadow dropdown-menu dropdown-menu-left animated--fade-in"
                                        aria-labelledby="dropdownMenuButton" x-placement="bottom-start"
                                        style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">&nbsp;&nbsp;


                                        <a href="<?= SYS_URL ?>suppliers/edit.php?id=<?= $row['id'] ?>"
                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>Edit</a>
                                        <a class="btn btn-danger btn-sm"
                                            href="<?= SYS_URL ?>suppliers/delete.php?id=<?= $row['id'] ?>"
                                            onclick="return confirmDelete();"><i class="fas fa-trash"></i> Delete</a>

                                    </div>
                                </div>
                            </td>
                            <td>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                    <select name="Status" id="Status" class="form-control-sm"
                                        onchange="this.form.submit()">
                                        <option value="1" <?= ($row['Status']==1)?'selected': '' ?>>Active</option>
                                        <option value="0" <?= ($row['Status']==0) ? 'selected' : '' ?>>Deactive</option>
                                    </select>
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                </form>
                                <?php
                                
                                
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    extract($_POST);
                                    
                                
                                    if (!empty($id) && isset($Status)) {
                                        $db =dbConn();
                                        $sql = "UPDATE supplier SET Status='$Status' WHERE id='$id'";
                                        $result1 = $db->query($sql);
                                         if($result1){
                                            $alert=true;
                                         } else{
                                            $alert =false;
                                         }  
                                        }
                                    }
                                }
                                
                                ?>


                            </td>
                        </tr>

                        <?php
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
        position: "top-end",
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

