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
    $FirstName = dataClean($FirstName);
    $LastName = dataClean($LastName);
    $DesignationId = dataClean($DesignationId);
    $AppDate = dataClean($AppDate);
    $UserName = dataClean($UserName);
    
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
    if (empty($UserName)) {
        $message['UserName'] = "The UserName should not be blank...!";
    }
    if (empty($Password)) {
        $message['Password'] = "The Password should not be blank...!";
    }
    if (empty($confirm_password)) {
        $message['confirm_password'] = "confirm Password is required";
    }

    //check username exist
    if (!empty($UserName)) {
        $db = dbConn();
        $sql = "SELECT * FROM users WHERE UserName='$UserName'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['UserName'] = "This User Name already exist...!";
        }
    }

     //Advance validation------------------------------------------------
     if (ctype_alpha(str_replace(' ', '', $FirstName)) === false) {
        $message['$FirstName'] = "Only letters and white space allowed";
    }
    if (ctype_alpha(str_replace(' ', '', $LastName)) === false) {
        $message['LastName'] = "Only letters and white space allowed";
    }
    
    if ($Password !== $confirm_password){
        $message['confirm_password'] = "passwords do not match. please try again";
    } 

    //check password strength
    if (!empty($Password)) {
        $uppercase = preg_match('@[A-Z]@', $Password);
        $lowercase = preg_match('@[a-z]@', $Password);
        $number = preg_match('@[0-9]@', $Password);
        $specialChars = preg_match('@[^\w]@', $Password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($Password) < 8) {
            $message['Password'] = 'Password should be at least 8 characters in length and should include at least one uppercase letter, one lowercase letter, one number, and one special character.';
        }
    }
    if (empty($message)) {
        //Use bcrypt hashing algorithem
        $pw = password_hash($Password, PASSWORD_DEFAULT);
        $db = dbConn();
        $sql = "INSERT INTO users(FirstName,LastName,UserName,Password,UserType,Status) VALUES ('$FirstName','$LastName','$UserName','$pw','employee','1')";
        $db->query($sql);
        $UserId = $db->insert_id;

        $sql = "INSERT INTO employee(AppDate,DesignationId,UserId) VALUES ('$AppDate','$DesignationId','$UserId')";
        $db->query($sql);

        header("Location:manage.php");
    }
 
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>users/manage.php" class="btn bg-warning mb-2"><i class="fas fa-plus-circle"></i> View
            User</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New User</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" novalidate>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputFirstName">First Name</label>
                                <input type="text" class="form-control" id="FirstName" name="FirstName"
                                    placeholder="Enter First Name" value="<?= @$FirstName ?>">
                                <span class="text-danger"><?= @$message['FirstName'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputLastName">Last Name</label>
                                <input type="text" class="form-control" id="LastName" name="LastName"
                                    placeholder="Enter Last Name" value="<?= @$LastName ?>">
                                <span class="text-danger"><?= @$message['LastName'] ?></span>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-6">
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
                                    <option value="<?= $row['Id'] ?>" <?= @$DesignationId==$row['Id']?'selected':'' ?>>
                                        <?= $row['Designation'] ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?= @$message['DesignationId'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-6">

                            <div class="form-group">
                                <label for="AppDate">Appointment Date</label>
                                <input type="date" class="form-control" id="AppDate" name="AppDate"min="<?=date('Y-m-d')?>"
                                max="<?=date('Y-m-d') ?>"value="<?= @$AppDate ?>">
                                <span class="text-danger"><?= @$message['AppDate'] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="UserName">User Name</label>
                        <input type="text" class="form-control" id="UserName" name="UserName" value="<?= @$UserName ?>"
                            placeholder="Enter User Name" required>
                        <span class="text-danger"><?= @$message['UserName'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" class="form-control" id="Password" name="Password"
                            placeholder="Password" required>
                        <span class="text-danger"><?= @$message['Password'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class=" form-control" name="confirm_password"
                            id="confirm_password" placeholder="confirm_password" required>
                        <span class="text-danger"><?= @$message['confirm_password'] ?></span>
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