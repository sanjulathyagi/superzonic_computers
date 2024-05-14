<?php
ob_start();
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

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New customer</h3>
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
                        <label for="Email">Email</label>
                        <input type="date" class="form-control" id="Email" name="Email" value="<?= @$Email ?>">
                        <span class="text-danger"><?= @$message['Email'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="AddressLine1">AddressLine1</label>
                        <input type="text" class="form-control" id=AddressLine1" name="AddressLine1" value="<?= @$AddressLine1 ?>"
                            placeholder="Enter AddressLine1">
                        <span class="text-danger"><?= @$message['AddressLine1'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="AddressLine2">AddressLine2</label>
                        <input type="text" class="form-control" id="AddressLine2" name="AddressLine2" value="<?= @$AddressLine2 ?>"
                            placeholder="Enter AddressLine2">
                        <span class="text-danger"><?= @$message['AddressLine2'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="AddressLine3">AddressLine3</label>
                        <input type="text" class="form-control" id="AddressLine3" name="AddressLine3" value="<?= @$AddressLine3 ?>"
                            placeholder="Enter AddressLine3">
                        <span class="text-danger"><?= @$message['AddressLine3'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="Gender">Gender</label>
                        <input type="Gender" class="form-control" id="Gender" name="Gender"
                            placeholder="Gender">
                        <span class="text-danger"><?= @$message['Gender'] ?></span>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
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