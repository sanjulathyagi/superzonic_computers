<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Customer Management";
$breadcrumb_item = "Customer";
$breadcrumb_item_active = "Update";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    extract($_GET);
    $db = dbConn();
    $sql = "SELECT c.*, d.Name 
            FROM customers c
            INNER JOIN districts d ON d.Id = c.DistrictId";
            

    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $FirstName = $row['FirstName'];
    $LastName = $row['LastName'];
    $Email = $row['Email'];
    $AddressLine1 = $row['AddressLine1'];
    $AddressLine2 = $row['AddressLine2'];
    $AddressLine3 = $row['AddressLine3'];
    $TelNo = $row['TelNo'];
    $MobileNo = $row['MobileNo'];
    $DistrictId = $row['DistrictId'];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $FirstName = dataClean($FirstName);
    $LastName = dataClean($LastName);
    $Email = dataClean($Email);
    $AddressLine1 = dataClean($AddressLine1);
    $AddressLine2 = dataClean($AddressLine2);
    $AddressLine3 = dataClean($AddressLine3);
    $TelNo = dataClean($TelNo);
    $MobileNo = dataClean($MobileNo);
    $Id = dataClean($Id);

   

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
        $message['AddressLine3'] = "The city should not be blank...!";
    }
    if (empty($TelNo)) {
        $message['TelNo'] = "The TelNo should not be blank...!";
    }
    if (empty($MobileNo)) {
        $message['MobileNo'] = "The MobileNo should not be blank...!";
    }
    if (empty($Id)) {
        $message['Id'] = "The district Name should not be blank...!";
    }
  
   
    if (empty($message)) {
              
        $db = dbConn();
        $sql = "UPDATE customers c SET FirstName='$FirstName',LastName='$LastName',Email='$Email',AddressLine1='$AddressLine1',AddressLine='$AddressLine2',AddressLine3='$AddressLine3',
        MobileNo='$MobileNo',TelNo='$TelNo',DistrictId='$DistrictId' WHERE CustomerId='$CustomerId'";
        $db->query($sql);

        header("Location:manage.php");
    }
}
?>
<div class="row">
    <div class="col-12">

        <div class="card card-primary">
            <div class="card-header bg-dark">
                <h3 class="card-title">Update User</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputFirstName">First Name</label>
                                <input type="text" class="form-control" id="FirstName" name="FirstName"
                                    placeholder="Enter First Name" value="<?= @$FirstName ?>">
                                <span class="text-danger"><?= @$message['FirstName'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputLastName">Last Name</label>
                                <input type="text" class="form-control" id="LastName" name="LastName"
                                    placeholder="Enter Last Name" value="<?= @$LastName ?>">
                                <span class="text-danger"><?= @$message['LastName'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputEmail">Email</label>
                                <input type="text" class="form-control" id="Email" name="Email"
                                    placeholder="Enter Email" value="<?= @$Email ?>">
                                <span class="text-danger"><?= @$message['Email'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputAddressLine1">AddressLine1</label>
                                <input type="text" class="form-control" id="AddressLine1" name="AddressLine1"
                                    placeholder="Enter AddressLine1" value="<?= @$AddressLine1 ?>">
                                <span class="text-danger"><?= @$message['AddressLine1'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputAddressLine2">AddressLine2</label>
                                <input type="text" class="form-control" id="AddressLine2" name="AddressLine2"
                                    placeholder="Enter AddressLine2" value="<?= @$AddressLine2 ?>">
                                <span class="text-danger"><?= @$message['AddressLine2'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputAddressLine3">city</label>
                                <input type="text" class="form-control" id="AddressLine3" name="AddressLine3"
                                    placeholder="Enter city" value="<?= @$AddressLine3 ?>">
                                <span class="text-danger"><?= @$message['AddressLine3'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputTelNotFirstName">TelNo</label>
                                <input type="text" class="form-control" id="TelNo" name="TelNo"
                                    placeholder="Enter TelNo" value="<?= @$TelNo ?>">
                                <span class="text-danger"><?= @$message['TelNo'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group ">
                                <label for="inputMobileNo">MobileNo </label>
                                <input type="text" class="form-control" id="MobileNo " name="MobileNo "
                                    placeholder="Enter MobileNo " value="<?= @$MobileNo  ?>">
                                <span class="text-danger"><?= @$message['MobileNo '] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <!-- <div class="form-group ">
                                <label for="inputName">District</label>
                                <input type="text" class="form-control" id="Name" name="Name"
                                    placeholder="Enter district Name" value="<?= @$Name ?>">
                                <span class="text-danger"><?= @$message['Name'] ?></span>
                            </div> -->
                            <div class="form-group">
                            <label for="inputName">District</label>
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM districts";
                        $result = $db->query($sql);
                        ?>
                        <select class="form-control" id="Name" name="Name">
                            <option value="">--</option>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                            <option value="<?= $row['Id'] ?>" <?= @$Name == $row['Id'] ? 'selected' : '' ?>>
                                <?= $row['Name'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="text-danger"><?= @$message['Name'] ?></span>
                    </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer ">
                    <input type="hidden" name="CustomerId" value="<?= $CustomerId ?>">
                    <button type="submit" class="btn btn-warning btn-sm ">Submit</button>
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