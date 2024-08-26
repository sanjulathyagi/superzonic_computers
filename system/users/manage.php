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
                          
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>App. Date</th>
                            <th>Designation</th>
                            
                            <th>Actions</th>
                            <th></th>
                            


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $status = 1;
                        if($result->num_rows> 0){
                            while ($row=$result->fetch_assoc()) {
                        ?>
                        <tr>
                            
                            <td><?= $row['FirstName'] ?></td>
                            <td><?= $row['LastName'] ?></td>
                            <td><?= $row['AppDate'] ?></td>
                            <td><?= $row['Designation'] ?></td>
                            
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