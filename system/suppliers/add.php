<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Suppliers Management";
$breadcrumb_item = "Suppliers";
$breadcrumb_item_active = "Add";


//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $SupplierName = dataClean($SupplierName);
    $Email = dataClean($Email);
    $Addressline1 = dataClean($Addressline1);
    $Addressline2 = dataClean($Addressline2);
    $Addressline3 = dataClean($Addressline3);
    $TelNo = dataClean($TelNo);
    $RegisterDate = dataClean($RegisterDate);


  
    
    $message = array();
    if (empty($SupplierName)) {
        $message['SupplierName'] = "The SupplierName should not be blank...!";
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
        $message['TelNo'] = "The Tel No should not be blank...!";
    }
    if (empty($RegisterDate)) {
        $message['RegisterDate'] = "The RegisterDate should not be blank...!";
    }
    if (empty($message)) {
     
        $db = dbConn();
        $sql = "INSERT INTO supplier(SupplierName,Email,Addressline1,Addressline2,Addressline3,TelNo,RegisterDate) VALUES ('$SupplierName','$Email','$Addressline1','$Addressline2','$Addressline3','$TelNo','$RegisterDate')";
        $db->query($sql);
    
        header("Location:manage.php");
    }
 
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>suppliers/manage.php" class="btn bg-warning btn-sm mb-2"><i
                class="fas fa-eye"></i> View Supplier</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New Supplier</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputSupplierName">Supplier Name</label>
                                <input type="text" class="form-control" id="SupplierName" name="SupplierName"
                                    placeholder="Enter SupplierName" value="<?= @$SupplierName ?>">
                                <span class="text-danger"><?= @$message['SupplierName'] ?></span>
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