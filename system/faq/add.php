<?php
ob_start();
session_start();
include_once '../init.php';

$link = "FAQ ";
$breadcrumb_item = "FAQ";
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
    <a href="<?= SYS_URL ?>customers/manage.php" class="btn bg-warning mb-2"><i class="fas fa-plus-circle"></i> View Stock</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New FAQ</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">

                    <div class="form-group">
                        <label for="inputQuestion">Question</label>
                        <input type="text" class="form-control" id="Question" name="Question"
                            placeholder="Enter Question" value="<?= @$Question ?>">
                        <span class="text-danger"><?= @$message['Question'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="inputAnswer">Answer</label>
                        <input type="text" class="form-control" id="Answer" name="Answer"
                            placeholder="Enter Answer" value="<?= @$Answer ?>">
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