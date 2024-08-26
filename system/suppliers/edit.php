<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Supplier Management";
$breadcrumb_item = "Supplier";
$breadcrumb_item_active = "Update";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    extract($_GET);
    $db = dbConn();
    $sql = "SELECT s.*
            FROM supplier s
            WHERE s.id = '$id' ";
          
            

    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    $id = $row['id'];
    $Email = $row['Email'];
    $Addressline1 = $row['Addressline1'];
    $Addressline2 = $row['Addressline2'];
    $Addressline3 = $row['Addressline3'];
    $TelNo = $row['TelNo'];
    $RegisterDate = $row['RegisterDate'];
    
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $id = dataClean($id);
    $Email = dataClean($Email);
    $Addressline1 = dataClean($Addressline1);
    $Addressline2 = dataClean($Addressline2);
    $Addressline3 = dataClean($Addressline3);
    $TelNo = dataClean($TelNo);
    $RegisterDate = dataClean($RegisterDate);




    $message = array();

    if (empty($SupplierName)) {
        $message['SupplierName'] = "The Supplier Name should not be blank...!";
    }
    if (empty($Email)) {
        $message['Email'] = "The Email should not be blank...!";
    }
    if (empty($Addressline1)) {
        $message['Addressline1'] = "The Addressline1 should not be blank...!";
    }
    if (empty($Addressline2)) {
        $message['Addressline2'] = "The Addressline2 should not be blank...!";
    }
    if (empty($Addressline3)) {
        $message['Addressline3'] = "The Addressline3 should not be blank...!";
    }
    if (empty($TelNo)) {
        $message['TelNo'] = "The TelNo should not be blank...!";
    }
    if (empty($RegisterDate)) {
        $message['RegisterDate'] = "The Register Date should not be blank...!";
    }
    
  
   
    if (empty($message)) {
              
        $db = dbConn();
        $sql = "UPDATE supplier s SET SupplierName='$SupplierName',Email='$Email',AddressLine1='$AddressLine1',AddressLine='$AddressLine2',AddressLine3='$AddressLine3',
        RegisterDate='$RegisterDate',TelNo='$TelNo' WHERE id='$id'";
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
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                                <label for="SupplierName">Supplier Name</label>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT id,SupplierName FROM supplier";
                                $result = $db->query($sql);
                                ?>
                                <select class="form-control" id="id" name="id">
                                    <option value="">--</option>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?= $row['id'] ?>" <?= @$supplier_id == $row['id'] ? 'selected' : '' ?>>
                                        <?= $row['SupplierName'] ?></option>
                                    <?php } ?>
                                </select>
                                <span class="text-danger"><?= @$message['id'] ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input type="text" class="form-control" id="Email" name="Email"
                                    placeholder="Enter Email" value="<?= @$Email ?>">
                                <span class="text-danger"><?= @$message['Email'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputAddressline1">AddressLine 1</label>
                                <input type="text" class="form-control" id="Addressline1" name="Addressline1"
                                    placeholder="Enter Addressline1" value="<?= @$Addressline1 ?>">
                                <span class="text-danger"><?= @$message['Addressline1'] ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputAddressline2">AddressLine 2</label>
                                <input type="text" class="form-control" id="Addressline2" name="Addressline2"
                                    placeholder="Enter Addressline2" value="<?= @$Addressline2 ?>">
                                <span class="text-danger"><?= @$message['Addressline2'] ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="inputAddressline3">City</label>
                                <input type="text" class="form-control" id="Addressline3" name="Addressline3"
                                    placeholder="Enter Addressline3" value="<?= @$Addressline3 ?>">
                                <span class="text-danger"><?= @$message['Addressline3'] ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputTelNo">Tel No</label>
                        <input type="text" class="form-control" id="TelNo" name="TelNo" placeholder="Enter TelNo"
                            value="<?= @$TelNo ?>">
                        <span class="text-danger"><?= @$message['TelNo'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="RegisterDate">Register Date</label>
                        <input type="date" class="form-control" id="RegisterDate" name="RegisterDate" value="<?= @$RegisterDate ?>">
                        <span class="text-danger"><?= @$message['RegisterDate'] ?></span>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer ">
                    <input type="hidden" name="id" value="<?= $id ?>">
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