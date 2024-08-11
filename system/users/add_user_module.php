<?php
ob_start();
session_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "Add";


//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $UserId = dataClean($UserId);
    $ModuleId = dataClean($ModuleId);
    $add = dataClean($add);
    $edit = dataClean($edit);
    $delete = dataClean($delete);
    
    
    $message = array();
    if (empty($UserId )) {
        $message['UserId '] = "The User  should not be blank...!";
    }
    if (empty($Name )) {
        $message['ModuleId '] = "The Module  should not be blank...!";
    }
    if ($add === '') {
        $message['add'] = "The add should not be blank...!";
    }
    if ($edit === '') {
        $message['edit'] = "The edit should not be blank...!";
    }
    if ($delete === '') {
        $message['delete'] = "The delete should not be blank...!";
    }
    

    //check name exist
    if (!empty($Name)) {
        $db = dbConn();
        $sql = "SELECT * FROM user_modules WHERE Id='$Id'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['ModuleId'] = "This  Name already exist...!";
        }
    }
    if (empty($message)) {
       
        $db = dbConn();
        $sql = "INSERT INTO user_module(UserId,ModuleID,add,edit,delete) VALUES ('$UserId','$ModuleID','$add','$edit','$delete')";
        $db->query($sql);
        

        header("Location:user_module.php");
    }
 

 
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>users/user_module.php" class="btn bg-warning mb-2 btn-sm"><i class="fas fa-plus-circle"></i> View
            User module</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New User role</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="DesignationId">Select User</label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT u.UserId,u.UserName 
                                    FROM users u 
                                    INNER JOIN employee e 
                                    ON e.UserId=u.UserId ";
                                    $result = $db->query($sql);
                            ?>
                            <select class="form-control" id="UserId" name="UserId">
                                <option value="">--</option>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                <option value="<?= $row['UserId'] ?>" <?= @$UserId==$row['UserId']?'selected':'' ?>>
                                    <?= $row['UserName'] ?></option>
                                <?php } ?>
                            </select>
                            <span class="text-danger"><?= @$message['UserId'] ?></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="DesignationId">Select Module</label>
                            <?php
                            $db = dbConn();
                            $sql = "SELECT Name FROM modules";
                            $result = $db->query($sql);
                            ?>
                            <select class="form-control" id="ModuleId" name="ModuleId">
                                <option value="">--</option>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                <option value="<?= $row['Name'] ?>" <?= @$ModuleId==$row['Name']?'selected':'' ?>>
                                    <?= $row['Name'] ?></option>
                                <?php } ?>
                            </select>
                            <span class="text-danger"><?= @$message['ModuleId'] ?></span>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="AppDate">Add</label>
                            <select name="add" id="add" class="form-control" required>
                                <option value="">--</option>
                                <option value="1"<?=isset($add) && $add=="1"?'selected':''?>>Yes
                                </option>
                                <option value="0" <?=isset($add) && $add=="1"?'selected':''?>>No</option>

                            </select>
                            <span class="text-danger"><?= @$message['add'] ?></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="AppDate">Edit</label>
                            <select name="edit" id="edit" class="form-control" required>
                                <option value="">--</option>
                                <option value="1"<?=isset($edit) && $edit=="1"?'selected':''?>>Yes
                                </option>
                                <option value="0"<?=isset($edit) && $edit=="0"?'selected':''?>>No
                                </option>

                            </select>
                            <span class="text-danger"><?= @$message['edit'] ?></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="AppDate">Delete</label>
                            <select name="delete" id="delete" class="form-control" required>
                                <option value="">--</option>
                                <option value="1" <?=isset($delete) && $delete=="1"?'selected':''?>>Yes
                                </option>
                                <option value="0" <?=isset($delete) && $delete=="0"?'selected':''?>>No
                                </option>

                            </select>
                            <span class="text-danger"><?= @$message['delete'] ?></span>
                        </div>
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


<?php
$content = ob_get_clean();
include '../layouts.php';
?>