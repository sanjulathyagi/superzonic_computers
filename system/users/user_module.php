<?php
ob_start();
session_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "User Module";

?>

<div class="row">
    <div class="col-12">
        <a href="<?=SYS_URL ?>users/add_user_module.php" class="mb-2 btn btn-warning btn-sm"><i class="fas fa-plus-circle"></i>New</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">User Module details</h3>

                
            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php
                $db= dbConn ();
                $sql= "SELECT um.* ,m.Name,u.UserName
                FROM user_modules um 
                INNER JOIN users u 
                    ON u.UserId=um.UserId
                INNER JOIN modules m 
                    ON m.Id=um.ModuleId; ";

                $result=$db->query($sql);

                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Module</th>
                            <th>Add</th>
                            <th>edit</th>
                            <th>delete</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $status = 1;
                        if($result->num_rows> 0){
                            while ($row=$result->fetch_assoc()) {
                        ?>
                        <tr>

                            <td width="100px"><?= $row['UserName'] ?></td>
                            <td width="100px"><?= $row['Name'] ?></td>
                            <td width="100px"><?= $row['add'] ?></td>
                            <td width="100px"><?= $row['edit'] ?></td>
                            <td width="100px"><?= $row['delete'] ?></td>
                            <td width="100px"><a href="<?= SYS_URL ?>users/edit_user_module.php?id=<?= $row['Id'] ?>"
                                    class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>Edit</a></td>
                            <td><a class="btn btn-danger btn-sm"
                                    href="<?= SYS_URL ?>users/delete_user_module.php?id=<?= $row['Id'] ?>"
                                    onclick="return confirmDelete();"><i class="fas fa-trash"></i> Delete</a></td>





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