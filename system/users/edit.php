<?php
ob_start();
session_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "Update";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {  //data pass through URL 

    extract($_GET);
    $db = dbConn();
    $sql = "SELECT * FROM users u
            INNER JOIN employee e 
            ON e.UserId=u.UserId 
            WHERE u.UserId='$userid'";

    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $FirstName = $row['FirstName'];   //assign variable from recent data
    $LastName = $row['LastName'];
    $DesignationId = $row['DesignationId'];
    $AppDate=$row['AppDate'];
    $UserId=$row['UserId'];
   
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $FirstName = dataClean($FirstName);
    $LastName = dataClean($LastName);
    $DesignationId = dataClean($DesignationId);
    $DepartmentId = dataClean($DepartmentId);
    $AppDate = dataClean($AppDate);
    
   

    $message = array();
    if (empty($FirstName)) {
        $message['FirstName'] = "The First Name should not be blank...!";
    }
    if (empty($LastName)) {
        $message['LastName'] = "The Last Name should not be blank...!";
    }
    if (empty($DesignationId)) {
        $message['DesignationId'] = "The Designation should not be blank...!";
    }
    if (empty($AppDate)) {
        $message['AppDate'] = "The App. Date should not be blank...!";
    }
   

     //Advance validation------------------------------------------------
     if (ctype_alpha(str_replace(' ', '', $FirstName)) === false) {
        $message['$FirstName'] = "Only letters and white space allowed";
    }
    if (ctype_alpha(str_replace(' ', '', $LastName)) === false) {
        $message['LastName'] = "Only letters and white space allowed";
    }
   
    if (empty($message)) {
              
        $db = dbConn();
        $sql = "UPDATE users SET FirstName='$FirstName',LastName='$LastName' WHERE UserId='$UserId'";
        $db->query($sql);
        

        $sql = "UPDATE employee SET AppDate='$AppDate',DesignationId='$DesignationId' WHERE UserId='$UserId'";
        $db->query($sql);

        header("Location:manage.php");
    }
}
?>
<div class="row">
    <div class="col-12">

        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Update User</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">

                    <div class="form-group">
                        <label for="inputFirstName">First Name</label>
                        <input type="text" class="form-control" id="FirstName" name="FirstName"
                            placeholder="Enter First Name" value="<?= @$FirstName ?>">
                        <span class="text-danger"><?= @$message['FirstName'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="inputLastName">Last Name</label>
                        <input type="text" class="form-control" id="LastName" name="LastName"
                            placeholder="Enter Last Name" value="<?= @$LastName ?>">
                        <span class="text-danger"><?= @$message['LastName'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="DesignationId">Designation</label>
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM designations";
                        $result = $db->query($sql);
                        ?>
                        <select class="form-control" id="DesignationId" name="DesignationId">
                            <option value="">--</option>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                            <option value="<?= $row['Id'] ?>" <?= @$DesignationId == $row['Id'] ? 'selected' : '' ?>>
                                <?= $row['Designation'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="text-danger"><?= @$message['DesignationId'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="AppDate">Appointment Date</label>
                        <input type="date" class="form-control" id="AppDate" name="AppDate" value="<?= @$AppDate ?>">
                        <span class="text-danger"><?= @$message['AppDate'] ?></span>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <input type="hidden" name="UserId" value="<?= $UserId ?>">
                    <button type="submit" class="btn btn-warning">Submit</button>
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