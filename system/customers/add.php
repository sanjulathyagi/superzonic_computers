<?php
ob_start();
session_start();
include_once '../init.php';

$link = "customer Management";
$breadcrumb_item = "customer";
$breadcrumb_item_active = "Add";


//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $FirstName = dataClean($FirstName);
    $LastName = dataClean($LastName);
    $Email = dataClean($Email);
    $AddressLine1 = dataClean($AddressLine1);
    $AddressLine2 = dataClean($AddressLine2);
    $AddressLine3 = dataClean($AddressLine3);
    $Gender = dataClean($Gender);
    
    
    $message = array();
    if (empty($FirstName)) {
        $message['FirstName'] = "The First Name should not be blank...!";
    }
    if (empty($LastName)) {
        $message['LastName'] = "The Last Name should not be blank...!";
    }
    if (empty($Email)) {
        $message['Email'] = "The Email should not be blank...!";
    }
    if (empty($AddressLine1)) {
        $message['AddressLine1'] = "The AddressLine1 Date should not be blank...!";
    }
    if (empty($AddressLine2)) {
        $message['AddressLine2'] = "The AddressLine2 should not be blank...!";
    }
    if (empty($AddressLine3)) {
        $message['AddressLine3'] = "The AddressLine3 should not be blank...!";
    }
    if (empty($Gender)) {
        $message['Gender'] = "The Gender should not be blank...!";
    }
    
  
 
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>customers/manage.php" class="btn bg-warning btn-sm mb-2"><i
                class="fas fa-plus-circle"></i> View customers</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New customer</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
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
                                <label for="Email">Email</label>
                                <input type="text" class="form-control" id="Email" name="Email" value="<?= @$Email ?>">
                                <span class="text-danger"><?= @$message['Email'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Gender">Gender</label>
                                <select class="form-control" id="Gender" name="Gender">
                                    <option value="">
                                        Select Gender
                                    </option>
                                
                                    <option value="<?= $row['Id'] ?>" <?= @$Gender==$row['Id']?'selected':'' ?>>
                                        <?= $row['Gender'] ?></option>
                                    
                                </select>
                                <span class="text-danger"><?= @$message['Gender'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="AddressLine1">AddressLine1</label>
                                <input type="text" class="form-control" id="AddressLine1" name="AddressLine1"
                                    value="<?= @$AddressLine1 ?>" placeholder="Enter AddressLine1">
                                <span class="text-danger"><?= @$message['AddressLine1'] ?></span>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="AddressLine2">AddressLine2</label>
                                <input type="text" class="form-control" id="AddressLine2" name="AddressLine2"
                                    value="<?= @$AddressLine2 ?>" placeholder="Enter AddressLine2">
                                <span class="text-danger"><?= @$message['AddressLine2'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="AddressLine3">City</label>
                                <input type="text" class="form-control" id="AddressLine3" name="AddressLine3"
                                    value="<?= @$AddressLine3 ?>" placeholder="Enter AddressLine3">
                                <span class="text-danger"><?= @$message['AddressLine3'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputTelNo">Tel No</label>
                                <input type="text" class="form-control" id="TelNo" name="TelNo"
                                    placeholder="Enter TelNo" value="<?= @$TelNo ?>">
                                <span class="text-danger"><?= @$message['TelNo'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="inputMobileNo">Mobile No</label>
                                <input type="text" class="form-control" id="MobileNo" name="MobileNo"
                                    placeholder="Enter MobileNo" value="<?= @$MobileNo ?>">
                                <span class="text-danger"><?= @$message['MobileNo'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group ">
                                <label for="inputDistrict ">District </label>
                                <select name="Name" id="Name" class="form-control" required>
                                    <option value=""></option>
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM districts";
                                    $result = $db->query($sql);
                                    if($result->num_rows>0){
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                    <option value="<?= $row['Id']?>">
                                        <?= @$Name==$row['Id']?'selected':'' ?><?= $row['Name']?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="UserName">User Name</label>
                                <input type="text" class="form-control" id="UserName" name="UserName"
                                    value="<?= @$UserName ?>" placeholder="Enter User Name">
                                <span class="text-danger"><?= @$message['UserName'] ?></span>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning btn-sm">Submit</button>
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