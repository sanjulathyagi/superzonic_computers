<?php
ob_start();
include_once '../init.php';

$link = "Services ";
$breadcrumb_item = "Services";
$breadcrumb_item_active = "Add";


//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $FirstName = dataClean($FirstName);
    $LastName = dataClean($LastName);

    
    
    $message = array();
    if (empty($FirstName)) {
        $message['FirstName'] = "The First Name should not be blank...!";
    }
    if (empty($LastName)) {
        $message['LastName'] = "The Last Name should not be blank...!";
    }

  
 
}
?>
<div class="row">
    <div class="col-12">
    
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New Service</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">

                    <div class="form-group">
                        <label for="inputQuestion">Service Name</label>
                        <input type="text" class="form-control" id="Question" name="Question"
                            placeholder="Enter Service Name" value="<?= @$Question ?>">
                        <span class="text-danger"><?= @$message['Question'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="inputAnswer">Publish Date</label>
                        <input type="text" class="form-control" id="Answer" name="Answer"
                            placeholder="Publish Date" value="<?= @$Answer ?>">
                        <span class="text-danger"><?= @$message['Answer'] ?></span>
                    </div>
                    
                    
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
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