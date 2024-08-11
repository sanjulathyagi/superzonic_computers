<?php
ob_start();
session_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "Manage";
$alert=false;
?>

<div class="row">
    <div class="col-12">
        <?php
        $previlage= checkprivilege('1');
        ?>
        <a href="<?=SYS_URL ?>users/add.php" class="mb-2 btn btn-warning btn-sm"><i
                class="fas fa-plus-circle"></i>New User</a>
        <a href="<?=SYS_URL ?>users/add_designation.php" class="mb-2 btn btn-warning btn-sm"><i
                class="fas fa-plus-circle"></i>New Designation</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User details</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="float-right form-control" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php
                $db= dbConn ();
                $sql= "SELECT * ,e.status
                FROM users u 
                 INNER JOIN employee e 
                    ON e.UserId=u.UserId 
                 LEFT JOIN designations p 
                    ON p.ID=e.DesignationId";

                $result=$db->query($sql);

                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>App. Date</th>
                            <th>Designation</th>
                            <th>Status</th>
                            <th>Actions</th>
                            <th></th>
                            <th>Change status</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $status = 1;
                        if($result->num_rows> 0){
                            while ($row=$result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['UserId'] ?></td>
                            <td><?= $row['FirstName'] ?></td>
                            <td><?= $row['LastName'] ?></td>
                            <td><?= $row['AppDate'] ?></td>
                            <td><?= $row['Designation'] ?></td>
                            <td><?= ($row['status'] == 1) ? '<button class="btn btn-success btn-sm " style="width: 80px;">Active</button>' : '<button class="btn btn-danger btn-sm" style="width: 80px;">Disable</button>'; ?>
                            </td>
                            <td><a href="<?= SYS_URL ?>users/edit.php?userid=<?= $row['UserId'] ?>"
                                    class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>Edit</a></td>

                            <td> <?php
                                    if(($row['UserType']!='admin')&&($row['UserType']!='owner')){
                                    
                                    ?>
                                    <a class="btn btn-danger btn-sm"
                                    href="<?= SYS_URL ?>users/delete.php?userid=<?= $row['UserId'] ?>"
                                    onclick="return confirmDelete();"><i class="fas fa-trash"></i> Delete</a></td>
                                    <?php
                                    }
                                    ?>
                                

                            <td>
                                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                    <select name="status" id="status" class="form-control-sm"
                                        onchange="this.form.submit()">
                                        <option value="1" <?= ($row['status']==1)?'selected': '' ?>>Active</option>
                                        <option value="0" <?= ($row['status']==0) ? 'selected' : '' ?>>Deactive</option>
                                    </select>
                                    <input type="hidden" name="EmployeeId" value="<?= $row['EmployeeId'] ?>">
                                </form>
                                <?php
                                
                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    extract($_POST);
                                    $EmployeeId= $_POST['EmployeeId'];
                                    $status = $_POST['status'];
                                
                                    if (!empty($id) && isset($status)) {
                                        $db =dbConn();
                                        $sql = "UPDATE employee SET status='$status' WHERE id='$EmployeeId'";
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