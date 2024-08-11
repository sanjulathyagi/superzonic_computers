<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Quiz Management";
$breadcrumb_item = "Quiz";
$breadcrumb_item_active = "Add";


//check post and data clean
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $question = dataClean($question);
    $option1 = dataClean($option1);
    $option2 = dataClean($option2);
    $option3 = dataClean($option3);
    $option4 = dataClean($option4);
    $correct_option = dataClean($correct_option);
  
    
    $message = array();
    if (empty($question)) {
        $message['question'] = "The question should not be blank...!";
    }
    if (empty($option1)) {
        $message['option1'] = "The option1 should not be blank...!";
    }
    if (empty($option2)) {
        $message['option2'] = "The option2 should not be blank...!";
    }
    if (empty($option3)) {
        $message['option3'] = "The option3 should not be blank...!";
    }
    if (empty($option4)) {
        $message['option4'] = "The option4 should not be blank...!";
    }
    if (empty($correct_option)) {
        $message['correct_option'] = "The correct_option should not be blank...!";
    }
    
  
}
?>
<div class="row">
    <div class="col-12">
        <a href="<?= SYS_URL ?>Quiz/manage.php" class="btn btn-warning mb-2"><i class="fas fa-plus-circle"></i>view</a>
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Add New Question</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="form-group">
                                <label for="inputBrand">Question</label>
                                <input type="text" class="form-control" id="question" name="question"
                                    placeholder="Enter question" value="<?= @$question ?>">
                                <span class="text-danger"><?= @$message['question'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="inputoption1">option 1</label>
                                <input type="text" class="form-control" id="option1" name="option1"
                                    placeholder="Enter option1" value="<?= @$option1 ?>">
                                <span class="text-danger"><?= @$message['option1'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="inputoption2">option 2</label>
                                <input type="text" class="form-control" id="option2" name="option2"
                                    placeholder="Enter option2" value="<?= @$option2 ?>">
                                <span class="text-danger"><?= @$message['option2'] ?></span>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="inputoption3">option 3</label>
                                <input type="text" class="form-control" id="option3" name="option3"
                                    placeholder="Enter option3" value="<?= @$option3 ?>">
                                <span class="text-danger"><?= @$message['option3'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="inputoption4">option 4</label>
                                <input type="text" class="form-control" id="option4" name="option4"
                                    placeholder="Enter option4" value="<?= @$option4 ?>">
                                <span class="text-danger"><?= @$message['option4'] ?></span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="inputoption4"> correct option </label>
                                <input type="text" class="form-control" id="option4" name="option4"
                                    placeholder="Enter option4" value="<?= @$option4 ?>">
                                <span class="text-danger"><?= @$message['option4'] ?></span>
                            </div>
                        </div>
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