<?php
ob_start();
session_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "Add Designation";


//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $Designation = dataClean($Designation);

    
    $message = array();
    if (empty($Designation)) {
        $message['Designation'] = "The Designation should not be blank...!";
    }
    
    //check username exist
    if (!empty($Designation)) {
        $db = dbConn();
        $sql = "SELECT * FROM Designations WHERE Designation='$Designation'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['Designation'] = "This Designation already exist...!";
        }
    }

  
    if (empty($message)) {
       
        $db = dbConn();
        $sql = "INSERT INTO Designations (Designation) VALUES ('$Designation')";
        $db->query($sql);
        

        // header("Location:manage.php");
    }
 
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>users/manage.php" class="btn bg-warning mb-2"><i class="fas fa-plus-circle"></i> View
            User</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New Designation</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">

                    <div class="form-group">
                        <label for="inputDesignation">Designation</label>
                        <input type="text" class="form-control" id="Designation" name="Designation"
                            placeholder="Enter Designation" value="<?= @$Designation ?>">
                        <span class="text-danger"><?= @$message['Designation'] ?></span>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning btn-sm">Submit </button>
                </div>
            </form>

        </div>
        <!-- /.card -->
    </div>
</div>
<div class="row">
    <div class="col-12">
     
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Designation details</h3>

                
            </div>
            <!-- /.card-header -->
            <div class="p-0 card-body table-responsive">
                <?php
                $db= dbConn ();
                $sql= "SELECT d.* 
                FROM designations d
                
                 ";

                $result=$db->query($sql);

                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>

                            <th>Designation</th>
                       
                            <th>Actions</th>
                            


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $status = 1;
                        if($result->num_rows> 0){
                            while ($row=$result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['Id'] ?></td>

                            <td><?= $row['Designation'] ?></td>
                            

                            <td><?php
                                    if(($row['Designation']!='admin')&&($row['Designation']!='owner')){
                                    
                                    ?>
                                <a class="btn btn-danger btn-sm"
                                    href="<?= SYS_URL ?>users/delete_designation.php?id=<?= $row['Id'] ?>"
                                    onclick="return confirmDelete();"><i class="fas fa-trash"></i> Delete</a></td>
                                    <?php
                                    }
                                    ?>

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
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this record?");
    }
</script>

<?php
$content = ob_get_clean();
include '../layouts.php';
?>